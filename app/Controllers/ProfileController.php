<?php

require_once '../core/Controller.php';
require_once '../app/Models/User.php';

class ProfileController extends Controller
{
    /**
     * Show user profile page
     */
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /web_final_project/public/login");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($userId);

        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            header("Location: /web_final_project/public/");
            exit;
        }

        $this->view('profile/index', ['user' => $user]);
    }

    /**
     * Update user profile
     */
    public function update()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /web_final_project/public/login");
            exit;
        }

        // Basic validation
        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (empty($name)) {
            $errors['name'] = 'Name is required.';
        }
        if (empty($email)) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }
        if (!empty($password) && strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters.';
        }
        if (!empty($password) && $password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Passwords do not match.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            header("Location: /web_final_project/public/profile");
            exit;
        }

        $data = [
            'name' => $name,
            'email' => $email
        ];

        if (!empty($password)) {
            $data['password'] = $password;
        }

        $userModel = new User();
        if ($userModel->update($userId, $data)) {
            // Update session name
            $_SESSION['user_name'] = $name;
            $_SESSION['success'] = 'Profile updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update profile.';
        }

        header("Location: /web_final_project/public/profile");
        exit;
    }
}
