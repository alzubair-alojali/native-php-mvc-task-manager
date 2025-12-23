<?php

require_once '../core/Controller.php';
require_once '../app/Models/User.php';
require_once __DIR__ . '/../Requests/auth/RegisterRequest.php';
require_once __DIR__ . '/../Requests/auth/LoginRequest.php';
class AuthController extends Controller
{
    public function showRegisterForm()
    {
        // Guest guard: redirect logged-in users to dashboard
        $this->requireGuest();
        $this->view('auth/register');
    }

    public function register()
    {
        // Guest guard
        $this->requireGuest();

        $request = new RegisterRequest();
        $request->validate();

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $userModel = new User();
        if ($userModel->create($data)) {
            $newUser = $userModel->findByEmail($data['email']);
            $_SESSION['user_id'] = $newUser['id'];
            $_SESSION['user_name'] = $newUser['name'];
            header("Location: /dashboard");
            exit;
        } else {
            $_SESSION['error'] = 'Registration failed. Please try again.';
            header("Location: /register");
            exit;
        }

    }

    public function showLoginForm()
    {
        // Guest guard: redirect logged-in users to dashboard
        $this->requireGuest();
        $this->view('auth/login');
    }

    public function login()
    {
        // Guest guard
        $this->requireGuest();

        $request = new LoginRequest();
        $request->validate();
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'] ?? 'employee';

            header("Location: /dashboard");
            exit;
        } else {
            $_SESSION['errors'] = ['login' => 'Invalid email or password.'];
            $_SESSION['old'] = ['email' => $email];
            header("Location: /login");
            exit;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /");
        exit;
    }
}