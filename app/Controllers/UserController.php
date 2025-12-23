<?php

require_once '../core/Controller.php';
require_once '../app/Models/User.php';
require_once __DIR__ . '/../Requests/user/StoreUserRequest.php';
require_once __DIR__ . '/../Requests/user/UpdateUserRequest.php';

class UserController extends Controller
{
    /**
     * Check if current user is a manager (required for user management)
     */
    private function requireManager()
    {
        $this->requireAuth();

        if (($_SESSION['user_role'] ?? '') !== 'manager') {
            $_SESSION['error'] = 'Access denied. Only managers can manage users.';
            header("Location: /dashboard");
            exit;
        }
    }

    public function index()
    {
        $this->requireManager();

        $userModel = new User();
        $users = $userModel->getAll();
        $this->view('users/index', ['users' => $users]);
    }

    public function create()
    {
        $this->requireManager();
        $this->view('users/create');
    }

    public function store()
    {
        $this->requireManager();

        // Validate input before processing
        $request = new StoreUserRequest();
        $request->validate();

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        $userModel = new User();
        if ($userModel->create($data)) {
            $_SESSION['success'] = 'User created successfully.';
            header("Location: /users");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to create user. Please try again.';
            header("Location: /users/create");
            exit;
        }
    }

    public function edit()
    {
        $this->requireManager();

        $id = $_GET['id'] ?? null;
        $userModel = new User();
        $user = $userModel->findById($id);

        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            header("Location: /users");
            exit;
        }

        $this->view('users/edit', ['user' => $user]);
    }

    public function update()
    {
        $this->requireManager();

        $id = $_POST['id'] ?? null;

        // Validate input before processing
        $request = new UpdateUserRequest($id);
        $request->validate();

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'] ?? null,
            'role' => $_POST['role'] ?? null
        ];

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $userModel = new User();
        if ($userModel->update($id, $data)) {
            $_SESSION['success'] = 'User updated successfully.';
            header("Location: /users");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update user. Please try again.';
            header("Location: /users/edit?id=" . $id);
            exit;
        }
    }

    public function destroy()
    {
        $this->requireManager();

        $id = $_POST['id'] ?? null;

        // Prevent self-deletion
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'You cannot delete your own account.';
            header("Location: /users");
            exit;
        }

        $userModel = new User();
        if ($userModel->delete($id)) {
            $_SESSION['success'] = 'User deleted successfully.';
            header("Location: /users");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete user. Please try again.';
            header("Location: /users");
            exit;
        }
    }
}