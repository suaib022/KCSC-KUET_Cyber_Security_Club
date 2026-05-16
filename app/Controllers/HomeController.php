<?php
require_once APP_ROOT . '/config/database.php';

class HomeController
{
    /**
     * Display the homepage.
     */
    public function index(): void
    {
        $db = getDBConnection();
        $events = $db->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 5")->fetchAll();
        $notices = $db->query("SELECT * FROM notices ORDER BY created_at DESC LIMIT 5")->fetchAll();
        
        // Fetch team members
        require_once APP_ROOT . '/app/Models/Member.php';
        $memberModel = new Member($db);
        $teamMembers = $memberModel->getAllOrderedByHierarchy();
        $pageTitle   = APP_NAME;
        $pageDesc    = 'KUET Cyber Security Club — Learn, Hack, Secure. Join KUET\'s elite cybersecurity community.';
        $currentPage = 'home';
        $contentView = APP_ROOT . '/app/Views/pages/home.php';
        require APP_ROOT . '/app/Views/layouts/main.php';
    }
}
