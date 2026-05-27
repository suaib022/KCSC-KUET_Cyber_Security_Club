<?php
// Dependencies
require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/app/Models/Application.php';
require_once APP_ROOT . '/app/Services/ValidationService.php';

class JoinController
{
    /**
     * Display the join form (GET request).
     */
    public function index(): void
    {
        $pageTitle   = 'Join - KCSC';
        $pageDesc    = 'Apply to join the KUET Cyber Security Club. Fill out the registration form.';
        $currentPage = 'join';
        $contentView = APP_ROOT . '/app/Views/pages/join.php';
        require APP_ROOT . '/app/Views/layouts/main.php';

        // Clear old input after rendering so it doesn't persist on refresh
        unset($_SESSION['_flash']['old_input']);
    }

    /**
     * Handle form submission (POST request).
     */
    public function store(): void
    {
        $csrfToken = $_POST['_csrf_token'] ?? '';
        if (!verifyCsrfToken($csrfToken)) {
            flash('errors', ['form' => 'Invalid security token. Please try again.']);
            redirect(url('join.php'));
            return;
        }
        $validator = new ValidationService();
        $data = $validator->sanitize($_POST);
        $errors = $validator->validateJoinForm($data);
        $croppedBase64 = $_POST['cropped_image_base64'] ?? '';
        $imageError = $validator->validateImage($croppedBase64);
        if ($imageError) {
            $errors['image'] = $imageError;
        }

        if (!empty($errors)) {
            // Flash errors and old input, redirect back
            flash('errors', $errors);
            flash('old_input', $data);
            redirect(url('join.php'));
            return;
        }
        $imageUrl = null;
        if (!empty($croppedBase64)) {
            $apiKey = $_ENV['IMGBB_API_KEY'] ?? '';
            if (empty($apiKey)) {
                flash('errors', ['form' => 'Image upload configuration is missing.']);
                flash('old_input', $data);
                redirect(url('join.php'));
                return;
            }

            // Remove the data URI prefix (e.g. data:image/jpeg;base64,)
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $croppedBase64);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'key'   => $apiKey,
                'image' => $imageData
            ]);
            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);
            if (isset($result['data']['display_url'])) {
                $imageUrl = $result['data']['display_url'];
            } else {
                flash('errors', ['image' => 'Failed to upload image. Please try again.']);
                flash('old_input', $data);
                redirect(url('join.php'));
                return;
            }
        }
        $data['image_url'] = $imageUrl;
        try {
            $db          = getDBConnection();
            $application = new Application($db);
            $application->create($data);

            // Success
            flash('success', 'Your application has been submitted successfully! Welcome to KCSC.');
            redirect(url('join.php'));

        } catch (Exception $e) {
            // Log the error
            error_log('Join Form Error: ' . $e->getMessage());

            // Show generic error to user
            flash('errors', ['form' => 'An unexpected error occurred. Please try again later.']);
            flash('old_input', $data);
            redirect(url('join.php'));
        }
    }
}
