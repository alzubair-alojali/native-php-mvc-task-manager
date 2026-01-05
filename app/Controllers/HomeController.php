<?php

require_once '../core/Controller.php';
require_once '../app/Models/Service.php';
require_once '../app/Models/Setting.php';
require_once '../app/Models/Message.php';

class HomeController extends Controller
{
    /**
     * Show landing page (for guests only)
     * Logged-in users are redirected to dashboard
     */
    public function index()
    {
        // Guest guard: redirect logged-in users to dashboard
        $this->requireGuest();

        // Fetch dynamic landing page content
        $serviceModel = new Service();
        $settingModel = new Setting();

        $data = [
            'services' => $serviceModel->getAll(),
            'settings' => $settingModel->getAllAsAssociativeArray()
        ];

        $this->view('landing', $data);
    }

    /**
     * Handle contact form submission
     * Validates input and stores the message
     */
    public function sendMessage()
    {
        // Validate required fields
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Name is required.';
        }

        if (empty($email)) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if (empty($message)) {
            $errors['message'] = 'Message is required.';
        } elseif (strlen($message) < 10) {
            $errors['message'] = 'Message must be at least 10 characters.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'name' => $name,
                'email' => $email,
                'message' => $message
            ];
            header("Location: " . base_url('/#contact'));
            exit;
        }

        // Store the message
        $messageModel = new Message();
        $result = $messageModel->create([
            'name' => $name,
            'email' => $email,
            'message' => $message
        ]);

        if ($result) {
            $_SESSION['success'] = 'Thank you for your message! We will get back to you soon.';
        } else {
            $_SESSION['error'] = 'Failed to send message. Please try again.';
        }

        header("Location: " . base_url('/#contact'));
        exit;
    }
}
