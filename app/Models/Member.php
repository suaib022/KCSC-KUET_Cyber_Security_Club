<?php
class Member
{
    /** @var PDO */
    private PDO $db;

    /**
     * @param PDO $db PDO database connection
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Create a new member record.
     *
     * @param array $data Associative array with keys:
     *                    full_name, email, student_id, department, phone, role, image_url
     * @return bool True on success
     * @throws PDOException On database error
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO `members` (`full_name`, `email`, `student_id`, `department`, `phone`, `role`, `image_url`)
                VALUES (:full_name, :email, :student_id, :department, :phone, :role, :image_url)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':full_name'  => $data['full_name'],
            ':email'      => $data['email'],
            ':student_id' => $data['student_id'],
            ':department' => $data['department'],
            ':phone'      => $data['phone'],
            ':role'       => $data['role'],
            ':image_url'  => $data['image_url'] ?? null,
        ]);
    }

    /**
     * Check if an email already exists in the database.
     *
     * @param string $email
     * @return bool True if email exists
     */
    public function emailExists(string $email): bool
    {
        $sql  = "SELECT COUNT(*) FROM `members` WHERE `email` = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);

        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Check if a student ID already exists in the database.
     *
     * @param string $studentId
     * @return bool True if student ID exists
     */
    public function studentIdExists(string $studentId): bool
    {
        $sql  = "SELECT COUNT(*) FROM `members` WHERE `student_id` = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Get all members ordered by joined date.
     *
     * @return array Array of member records
     */
    public function getAll(): array
    {
        $sql  = "SELECT * FROM `members` ORDER BY `joined_at` DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * Get all members ordered by their hierarchical roles.
     *
     * @return array Array of member records
     */
    public function getAllOrderedByHierarchy(): array
    {
        $members = $this->getAll();
        
        $roles = [
            'President / Convener',
            'Vice President / Joint Convener',
            'General Secretary',
            'Assistant General Secretary',
            'Treasurer',
            'Chief Student Editor',
            'Associate / Assistant Editors',
            'Research & Workshop Coordinator',
            'Publication & Press Secretary',
            'Graphics & UI Design Lead',
            'Graphics Executives',
            'Public Relations & Communications Secretary',
            'PR Associates',
            'Media & Content Lead',
            'Content Writers',
            'Logistics Secretary',
            'Logistics Crew'
        ];
        
        usort($members, function($a, $b) use ($roles) {
            $posA = array_search($a['role'], $roles);
            if ($posA === false) $posA = 999;
            $posB = array_search($b['role'], $roles);
            if ($posB === false) $posB = 999;
            
            if ($posA === $posB) {
                return strtotime($a['joined_at']) <=> strtotime($b['joined_at']);
            }
            return $posA <=> $posB;
        });
        
        return $members;
    }

    /**
     * Find a member by ID.
     *
     * @param int $id
     * @return array|false Member record or false
     */
    public function findById(int $id)
    {
        $sql  = "SELECT * FROM `members` WHERE `id` = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Check if a President already exists in the club.
     *
     * @return bool True if a President exists
     */
    public function hasPresident(): bool
    {
        $sql  = "SELECT COUNT(*) FROM `members` WHERE `role` = 'President / Convener'";
        $stmt = $this->db->query($sql);
        return (int) $stmt->fetchColumn() > 0;
    }
}
