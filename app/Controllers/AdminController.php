<?php
require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/app/Models/Application.php';
require_once APP_ROOT . '/app/Models/Member.php';

class AdminController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getDBConnection();
    }

    /**
     * Display the admin dashboard.
     */
    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest();
            // Redirect to avoid form resubmission
            $tab = $_POST['tab'] ?? 'applications';
            header('Location: ' . url("admin.php?tab={$tab}"));
            exit;
        }
        $applications = $this->getApplications();
        $members = $this->getMembers();
        $events  = $this->getEvents();
        $notices = $this->getNotices();
        $events = $this->calculateEventStatuses($events);
        $pageTitle   = APP_NAME . ' | Admin Dashboard';
        $pageDesc    = 'Admin Dashboard for KCSC';
        $currentPage = 'admin';
        $activeTab   = $_GET['tab'] ?? 'applications';
        
        $contentView = APP_ROOT . '/app/Views/pages/admin/dashboard.php';
        
        require APP_ROOT . '/app/Views/layouts/main.php';
    }

    /**
     * Calculate event status dynamically.
     */
    private function calculateEventStatuses(array $events): array
    {
        $today = new DateTime();
        $today->setTime(0, 0, 0); // midnight

        foreach ($events as &$event) {
            $eventDate = new DateTime($event['event_date']);
            $eventDate->setTime(0, 0, 0);

            if ($eventDate > $today) {
                $event['status'] = 'Upcoming';
            } elseif ($eventDate == $today) {
                $event['status'] = 'Ongoing';
            } else {
                $event['status'] = 'Completed';
            }
        }

        return $events;
    }

    /**
     * Handle CRUD POST Requests.
     */
    private function handlePostRequest(): void
    {
        $action = $_POST['action'] ?? '';

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            if ($action === 'add_event') {
                $title = $_POST['title'] ?? '';
                $desc  = $_POST['description'] ?? '';
                $date  = $_POST['event_date'] ?? '';
                
                if ($title && $date) {
                    $year = (int) substr($date, 0, 4);
                    if ($year >= 1000 && $year <= 9999) {
                        $stmt = $this->db->prepare("INSERT INTO events (title, description, event_date) VALUES (?, ?, ?)");
                        $stmt->execute([$title, $desc, $date]);
                        $_SESSION['flash_success']['admin'] = "Event added successfully.";
                    } else {
                        $_SESSION['flash_errors']['admin'] = "Invalid event date.";
                    }
                } else {
                    $_SESSION['flash_errors']['admin'] = "Please provide all required fields for the event.";
                }
            } elseif ($action === 'delete_event') {
                $id = $_POST['id'] ?? 0;
                if ($id) {
                    $stmt = $this->db->prepare("DELETE FROM events WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['flash_success']['admin'] = "Event deleted successfully.";
                } else {
                    $_SESSION['flash_errors']['admin'] = "Invalid event ID.";
                }
            } elseif ($action === 'add_notice') {
                $title = $_POST['title'] ?? '';
                $content  = $_POST['content'] ?? '';
                if ($title && $content) {
                    $stmt = $this->db->prepare("INSERT INTO notices (title, content) VALUES (?, ?)");
                    $stmt->execute([$title, $content]);
                    $_SESSION['flash_success']['admin'] = "Notice added successfully.";
                } else {
                    $_SESSION['flash_errors']['admin'] = "Please provide all required fields for the notice.";
                }
            } elseif ($action === 'delete_notice') {
                $id = $_POST['id'] ?? 0;
                if ($id) {
                    $stmt = $this->db->prepare("DELETE FROM notices WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['flash_success']['admin'] = "Notice deleted successfully.";
                } else {
                    $_SESSION['flash_errors']['admin'] = "Invalid notice ID.";
                }
            } elseif ($action === 'delete_application') {
                $id = (int)($_POST['id'] ?? 0);
                if ($id > 0) {
                    $stmt = $this->db->prepare("DELETE FROM applications WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['flash_success']['admin'] = "Application rejected successfully.";
                } else {
                    $_SESSION['flash_errors']['admin'] = "Invalid application ID.";
                }
            } elseif ($action === 'approve_application') {
                $id = (int)($_POST['id'] ?? 0);
                $role = trim($_POST['role'] ?? '');

                if ($id > 0 && !empty($role)) {
                    $appModel = new Application($this->db);
                    $memberModel = new Member($this->db);

                    $app = $appModel->findById($id);
                    if ($app) {
                        if ($role === 'President / Convener' && $memberModel->hasPresident()) {
                            $_SESSION['flash_errors']['admin'] = "A President / Convener already exists! Please remove the current one first.";
                        } else {
                            $memberData = [
                                'full_name'  => $app['full_name'],
                                'email'      => $app['email'],
                                'student_id' => $app['student_id'],
                                'department' => $app['department'],
                                'phone'      => $app['phone'],
                                'image_url'  => $app['image_url'],
                                'role'       => $role
                            ];

                            $memberModel->create($memberData);
                            $stmt = $this->db->prepare("DELETE FROM applications WHERE id = ?");
                            $stmt->execute([$id]);
                            $_SESSION['flash_success']['admin'] = "Application approved. Member added successfully.";
                        }
                    } else {
                        $_SESSION['flash_errors']['admin'] = "Application not found.";
                    }
                } else {
                    $_SESSION['flash_errors']['admin'] = "Please select a valid role.";
                }
            } elseif ($action === 'delete_member') {
                $id = (int)($_POST['id'] ?? 0);
                if ($id > 0) {
                    $stmt = $this->db->prepare("DELETE FROM members WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['flash_success']['admin'] = "Member removed successfully.";
                } else {
                    $_SESSION['flash_errors']['admin'] = "Invalid member ID.";
                }
            }
        } catch (PDOException $e) {
            error_log('Admin Dashboard Error: ' . $e->getMessage());
            $_SESSION['flash_errors']['admin'] = "A database error occurred: " . $e->getMessage();
        } catch (Exception $e) {
            error_log('Admin Dashboard Error: ' . $e->getMessage());
            $_SESSION['flash_errors']['admin'] = "An unexpected error occurred.";
        }
    }

    private function getApplications(): array
    {
        $stmt = $this->db->query("SELECT * FROM applications ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    private function getMembers(): array
    {
        $stmt = $this->db->query("SELECT * FROM members ORDER BY joined_at DESC");
        return $stmt->fetchAll();
    }

    private function getEvents(): array
    {
        $stmt = $this->db->query("SELECT * FROM events ORDER BY event_date DESC");
        return $stmt->fetchAll();
    }

    private function getNotices(): array
    {
        $stmt = $this->db->query("SELECT * FROM notices ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
}
