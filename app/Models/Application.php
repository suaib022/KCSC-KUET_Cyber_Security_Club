<?php
class Application
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
     *                    full_name, email, student_id, department, phone, interest
     * @return bool True on success
     * @throws PDOException On database error
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO `applications` (`full_name`, `email`, `student_id`, `department`, `phone`, `interest`, `image_url`)
                VALUES (:full_name, :email, :student_id, :department, :phone, :interest, :image_url)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':full_name'  => $data['full_name'],
            ':email'      => $data['email'],
            ':student_id' => $data['student_id'],
            ':department' => $data['department'],
            ':phone'      => $data['phone'],
            ':interest'   => $data['interest'] ?? null,
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
        $sql  = "SELECT COUNT(*) FROM `applications` WHERE `email` = :email";
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
        $sql  = "SELECT COUNT(*) FROM `applications` WHERE `student_id` = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Get all members ordered by creation date.
     *
     * @return array Array of member records
     */
    public function getAll(): array
    {
        $sql  = "SELECT * FROM `applications` ORDER BY `created_at` DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * Find a member by ID.
     *
     * @param int $id
     * @return array|false Member record or false
     */
    public function findById(int $id)
    {
        $sql  = "SELECT * FROM `applications` WHERE `id` = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }
}
