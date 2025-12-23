<?php

require_once '../core/Controller.php';
require_once '../app/Models/Project.php';
require_once __DIR__ . '/../Requests/project/CreateProjectRequest.php';

class ProjectController extends Controller
{
    /**
     * Display list of projects for the logged-in manager
     */
    public function index()
    {
        // Security: Get manager ID from session
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $projectModel = new Project();
        $projects = $projectModel->getAllByManager($managerId);

        $this->view('projects/index', ['projects' => $projects]);
    }

    /**
     * Show create project form
     */
    public function create()
    {
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $this->view('projects/create');
    }

    /**
     * Store a new project in the database
     */
    public function store()
    {
        // Security: Get manager ID from session, NOT from form
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        // Validate input
        $request = new CreateProjectRequest();
        $request->validate();

        // Build project data
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'] ?? null,
            'deadline' => $_POST['deadline'],
            'status' => $_POST['status'] ?? 'pending',
            'manager_id' => $managerId  // From session, NOT from form
        ];

        $projectModel = new Project();
        $projectId = $projectModel->create($data);

        if ($projectId) {
            $_SESSION['success'] = 'Project created successfully.';
            header("Location: /projects");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to create project. Please try again.';
            header("Location: /projects/create");
            exit;
        }
    }

    /**
     * Show a single project's details
     */
    public function show()
    {
        $id = $_GET['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $projectModel = new Project();
        // Security: Only fetch if user is the manager
        $project = $projectModel->findById($id, $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Project not found or access denied.';
            header("Location: /projects");
            exit;
        }

        $this->view('projects/show', ['project' => $project]);
    }

    /**
     * Show edit project form
     */
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->findById($id, $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Project not found or access denied.';
            header("Location: /projects");
            exit;
        }

        $this->view('projects/edit', ['project' => $project]);
    }

    /**
     * Update a project
     */
    public function update()
    {
        $id = $_POST['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        // Validate input
        $request = new CreateProjectRequest();
        $request->validate();

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'] ?? null,
            'deadline' => $_POST['deadline'],
            'status' => $_POST['status'] ?? 'pending'
        ];

        $projectModel = new Project();
        // Security: Pass manager ID for ownership verification
        if ($projectModel->update($id, $data, $managerId)) {
            $_SESSION['success'] = 'Project updated successfully.';
            header("Location: /projects");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update project. Please try again.';
            header("Location: /projects");
            exit;
        }
    }

    /**
     * Delete a project
     */
    public function destroy()
    {
        $id = $_POST['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $projectModel = new Project();
        // Security: Pass manager ID for ownership verification
        if ($projectModel->delete($id, $managerId)) {
            $_SESSION['success'] = 'Project deleted successfully.';
            header("Location: /projects");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete project. Please try again.';
            header("Location: /projects");
            exit;
        }
    }
}
