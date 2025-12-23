<?php

require_once '../core/Controller.php';
require_once '../app/Models/Task.php';
require_once '../app/Models/Project.php';
require_once __DIR__ . '/../Requests/task/CreateTaskRequest.php';

class TaskController extends Controller
{
    /**
     * Display all tasks for a specific project
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

        // SECURITY: Verify project ownership before showing tasks
        $projectModel = new Project();
        $project = $projectModel->findById($projectId, $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Project not found or access denied.';
            header("Location: /projects");
            exit;
        }

        $taskModel = new Task();
        $tasks = $taskModel->getByProject($projectId);

        $this->view('tasks/index', [
            'tasks' => $tasks,
            'project' => $project
        ]);
    }

    /**
     * Show create task form
     */
    public function create()
    {
        $projectId = $_GET['project_id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
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

        $this->view('tasks/create', ['project' => $project]);
    }

    /**
     * Store a new task
     */
    public function store()
    {
        $managerId = $_SESSION['user_id'] ?? null;
        $projectId = $_POST['project_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        // CRITICAL SECURITY: Verify that the project belongs to this user
        // before allowing task creation
        $projectModel = new Project();
        $project = $projectModel->findById($projectId, $managerId);

        if (!$project) {
            $_SESSION['error'] = 'You do not have permission to add tasks to this project.';
            header("Location: /projects");
            exit;
        }

        // Validate input
        $request = new CreateTaskRequest();
        $request->validate();

        // Build task data
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'] ?? null,
            'due_date' => $_POST['due_date'] ?: null,
            'status' => $_POST['status'] ?? 'pending',
            'priority' => $_POST['priority'] ?? 'medium',
            'project_id' => $projectId,
            'assigned_to' => $_POST['assigned_to'] ?: null,
            'created_by' => $managerId  // From session
        ];

        $taskModel = new Task();
        $taskId = $taskModel->create($data);

        if ($taskId) {
            $_SESSION['success'] = 'Task created successfully.';
            header("Location: /tasks?project_id=" . $projectId);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to create task. Please try again.';
            header("Location: /tasks/create?project_id=" . $projectId);
            exit;
        }
    }

    /**
     * Show a single task
     */
    public function show()
    {
        $id = $_GET['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $taskModel = new Task();
        $task = $taskModel->findById($id);

        if (!$task) {
            $_SESSION['error'] = 'Task not found.';
            header("Location: /projects");
            exit;
        }

        // SECURITY: Verify project ownership
        $projectModel = new Project();
        $project = $projectModel->findById($task['project_id'], $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Access denied.';
            header("Location: /projects");
            exit;
        }

        $this->view('tasks/show', [
            'task' => $task,
            'project' => $project
        ]);
    }

    /**
     * Update task status (AJAX-friendly)
     */
    public function updateStatus()
    {
        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        // Validate status
        $allowedStatuses = ['pending', 'in_progress', 'completed'];
        if (!in_array($status, $allowedStatuses)) {
            $_SESSION['error'] = 'Invalid status.';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $taskModel = new Task();
        $task = $taskModel->findById($id);

        if (!$task) {
            $_SESSION['error'] = 'Task not found.';
            header("Location: /projects");
            exit;
        }

        // SECURITY: Verify project ownership before updating
        $projectModel = new Project();
        $project = $projectModel->findById($task['project_id'], $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Access denied.';
            header("Location: /projects");
            exit;
        }

        if ($taskModel->updateStatus($id, $status)) {
            $_SESSION['success'] = 'Task status updated.';
            header("Location: /tasks?project_id=" . $task['project_id']);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update task status.';
            header("Location: /tasks?project_id=" . $task['project_id']);
            exit;
        }
    }

    /**
     * Show edit task form
     */
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $taskModel = new Task();
        $task = $taskModel->findById($id);

        if (!$task) {
            $_SESSION['error'] = 'Task not found.';
            header("Location: /projects");
            exit;
        }

        // SECURITY: Verify project ownership
        $projectModel = new Project();
        $project = $projectModel->findById($task['project_id'], $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Access denied.';
            header("Location: /projects");
            exit;
        }

        $this->view('tasks/edit', [
            'task' => $task,
            'project' => $project
        ]);
    }

    /**
     * Update a task
     */
    public function update()
    {
        $id = $_POST['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $taskModel = new Task();
        $task = $taskModel->findById($id);

        if (!$task) {
            $_SESSION['error'] = 'Task not found.';
            header("Location: /projects");
            exit;
        }

        // SECURITY: Verify project ownership before updating
        $projectModel = new Project();
        $project = $projectModel->findById($task['project_id'], $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Access denied.';
            header("Location: /projects");
            exit;
        }

        // Validate input
        $request = new CreateTaskRequest();
        $request->validate();

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'] ?? null,
            'due_date' => $_POST['due_date'] ?: null,
            'status' => $_POST['status'] ?? 'pending',
            'priority' => $_POST['priority'] ?? 'medium',
            'assigned_to' => $_POST['assigned_to'] ?: null
        ];

        if ($taskModel->update($id, $data)) {
            $_SESSION['success'] = 'Task updated successfully.';
            header("Location: /tasks?project_id=" . $task['project_id']);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update task. Please try again.';
            header("Location: /tasks/edit?id=" . $id);
            exit;
        }
    }

    /**
     * Delete a task
     */
    public function destroy()
    {
        $id = $_POST['id'] ?? null;
        $managerId = $_SESSION['user_id'] ?? null;

        if (!$managerId) {
            header("Location: /login");
            exit;
        }

        $taskModel = new Task();
        $task = $taskModel->findById($id);

        if (!$task) {
            $_SESSION['error'] = 'Task not found.';
            header("Location: /projects");
            exit;
        }

        // SECURITY: Verify project ownership before deleting
        $projectModel = new Project();
        $project = $projectModel->findById($task['project_id'], $managerId);

        if (!$project) {
            $_SESSION['error'] = 'Access denied.';
            header("Location: /projects");
            exit;
        }

        $projectId = $task['project_id'];

        if ($taskModel->delete($id)) {
            $_SESSION['success'] = 'Task deleted successfully.';
            header("Location: /tasks?project_id=" . $projectId);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete task. Please try again.';
            header("Location: /tasks?project_id=" . $projectId);
            exit;
        }
    }

    /**
     * Display all tasks assigned to the current user (across all projects)
     */
    public function myTasks()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /login");
            exit;
        }

        $taskModel = new Task();
        $tasks = $taskModel->getAssignedToUser($userId);

        $this->view('tasks/my_tasks', [
            'tasks' => $tasks
        ]);
    }
}

