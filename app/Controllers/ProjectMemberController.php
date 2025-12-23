<?php

require_once '../core/Controller.php';
require_once '../core/Validator.php';
require_once '../app/Models/Project.php';
require_once '../app/Models/ProjectMember.php';
require_once '../app/Models/User.php';

class ProjectMemberController extends Controller
{
    /**
     * Display all members of a project
     */
    public function index()
    {
        $projectId = $_GET['project_id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        if (!$projectId) {
            $_SESSION['error'] = 'Project ID is required.';
            header("Location: /projects");
            exit;
        }

        // SECURITY: Verify project ownership
        $projectModel = new Project();
        $project = $projectModel->findById($projectId, $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Project not found or access denied.';
            header("Location: /projects");
            exit;
        }

        $memberModel = new ProjectMember();
        $members = $memberModel->getMembersByProject($projectId);

        $this->view('projects/members', [
            'members' => $members,
            'project' => $project
        ]);
    }

    /**
     * Add a member to a project (by email)
     */
    public function store()
    {
        $projectId = $_POST['project_id'] ?? null;
        $email = $_POST['email'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        // Validate input
        $validator = new Validator($_POST);
        $rules = [
            'email' => 'required|email',
            'project_id' => 'required'
        ];

        if (!$validator->make($rules)) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // SECURITY: Verify project ownership before adding members
        $projectModel = new Project();
        $project = $projectModel->findById($projectId, $managerId);

        if (!$project) {
            $_SESSION['error'] = 'You do not have permission to manage this project.';
            header("Location: /projects");
            exit;
        }

        // Find user by email
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $_SESSION['errors'] = ['email' => 'No user found with this email address.'];
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Prevent adding yourself (manager) as a member
        if ($user['id'] == $managerId) {
            $_SESSION['errors'] = ['email' => 'You cannot add yourself as a member. You are the project manager.'];
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Add member to project
        $memberModel = new ProjectMember();

        // Check for duplicate
        if ($memberModel->isMember($projectId, $user['id'])) {
            $_SESSION['errors'] = ['email' => 'This user is already a member of this project.'];
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($memberModel->addMember($projectId, $user['id'])) {
            $_SESSION['success'] = 'Member added successfully.';
            header("Location: /projects/members?project_id=" . $projectId);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to add member. Please try again.';
            header("Location: /projects/members?project_id=" . $projectId);
            exit;
        }
    }

    /**
     * Remove a member from a project
     */
    public function destroy()
    {
        $projectId = $_POST['project_id'] ?? null;
        $userId = $_POST['user_id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        // SECURITY: Verify project ownership before removing members
        $projectModel = new Project();
        $project = $projectModel->findById($projectId, $managerId);

        if (!$project) {
            $_SESSION['error'] = 'You do not have permission to manage this project.';
            header("Location: /projects");
            exit;
        }

        $memberModel = new ProjectMember();

        if ($memberModel->removeMember($projectId, $userId)) {
            $_SESSION['success'] = 'Member removed successfully.';
            header("Location: /projects/members?project_id=" . $projectId);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to remove member. Please try again.';
            header("Location: /projects/members?project_id=" . $projectId);
            exit;
        }
    }
}
