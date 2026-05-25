<?php
class ValidationService
{
    /** @var array Allowed department values */
    private const VALID_DEPARTMENTS = [
        'CSE', 'EEE', 'ECE', 'BME', 'MTE', 'CE', 'URP', 'BECM', 'ME', 'IEM', 'MSE', 'LE', 'TE', 'ESE', 'ChE', 'ARCH'
    ];

    /**
     * Validate the join/registration form data.
     *
     * @param array $data The form data (already trimmed)
     * @return array Associative array of field => error message. Empty if valid.
     */
    public function validateJoinForm(array $data): array
    {
        $errors = [];
        if (empty($data['full_name'])) {
            $errors['full_name'] = 'Full name is required.';
        } elseif (mb_strlen($data['full_name']) < 2) {
            $errors['full_name'] = 'Full name must be at least 2 characters.';
        } elseif (mb_strlen($data['full_name']) > 100) {
            $errors['full_name'] = 'Full name must not exceed 100 characters.';
        } elseif (!preg_match('/^[\p{L}\s.\'-]+$/u', $data['full_name'])) {
            $errors['full_name'] = 'Full name contains invalid characters.';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Email address is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        } elseif (mb_strlen($data['email']) > 255) {
            $errors['email'] = 'Email address is too long.';
        }
        if (empty($data['student_id'])) {
            $errors['student_id'] = 'Student ID is required.';
        } elseif (mb_strlen($data['student_id']) > 20) {
            $errors['student_id'] = 'Student ID must not exceed 20 characters.';
        } elseif (!preg_match('/^[A-Za-z0-9\-]+$/', $data['student_id'])) {
            $errors['student_id'] = 'Student ID can only contain letters, numbers, and hyphens.';
        }
        if (empty($data['department'])) {
            $errors['department'] = 'Please select a department.';
        } elseif (!in_array($data['department'], self::VALID_DEPARTMENTS, true)) {
            $errors['department'] = 'Invalid department selected.';
        }
        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone number is required.';
        } elseif (!preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $data['phone'])) {
            $errors['phone'] = 'Please enter a valid phone number (7-20 digits).';
        }
        if (!empty($data['interest']) && mb_strlen($data['interest']) > 2000) {
            $errors['interest'] = 'Interest text must not exceed 2000 characters.';
        }

        return $errors;
    }

    /**
     * Validate an uploaded image file or base64 string.
     *
     * @param string|null $base64 The cropped image base64 string
     * @return string|null Error message if invalid, null if valid.
     */
    public function validateImage(?string $base64): ?string
    {
        if (empty($base64)) {
            return 'Profile photo is required. Please select and crop an image.';
        }

        if (!preg_match('/^data:image\/(jpeg|png|jpg|webp);base64,/', $base64)) {
            return 'Invalid image format. Ensure the cropped image is valid.';
        }

        $size = strlen($base64) * 0.75;
        if ($size > 5 * 1024 * 1024) {
            return 'Image size is too large (max 5MB).';
        }

        return null;
    }

    /**
     * Sanitize and trim form input data.
     *
     * @param array $rawData Raw POST data
     * @return array Sanitized data
     */
    public function sanitize(array $rawData): array
    {
        $fields = ['full_name', 'email', 'student_id', 'department', 'phone', 'interest'];
        $clean  = [];

        foreach ($fields as $field) {
            $value = $rawData[$field] ?? '';
            // Trim whitespace and strip null bytes
            $clean[$field] = trim(str_replace("\0", '', $value));
        }

        // Normalize email to lowercase
        $clean['email'] = strtolower($clean['email']);

        return $clean;
    }
}
