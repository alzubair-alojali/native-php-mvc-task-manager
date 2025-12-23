<?php

require_once '../core/Controller.php';
require_once '../core/Validator.php';
require_once '../app/Models/Comment.php';
require_once '../app/Models/Task.php';
require_once '../app/Models/Project.php';
require_once '../app/Models/ProjectMember.php';

class CommentController extends Controller
{
    /**
     * Check if user has access to comment on a task
     * User must be either the project manager OR a project member
     * 
     * @param int $taskId Task ID
     * @param int $userId User ID
     * @return array|false Project data if allowed, false if denied
     */
    private function checkAccess($taskId, $userId)
    {
        // Step 1: Get the task and its project_id
        $taskModel = new Task();
        $task = $taskModel->findById($taskId);

        if (!$task) {
            return false;
        }

        $projectId = $task['project_id'];

        // Step 2: Check if user is the Project Manager (Owner)
        $projectModel = new Project();
        $project = $projectModel->findById($projectId);

        if (!$project) {
            return false;
        }

        // User is the manager
        if ($project['manager_id'] == $userId) {
            return ['project' => $project, 'task' => $task, 'role' => 'manager'];
        }

        // Step 3: Check if user is a Project Member
        $memberModel = new ProjectMember();
        if ($memberModel->isMember($projectId, $userId)) {
            return ['project' => $project, 'task' => $task, 'role' => 'member'];
        }

        // User has no access
        return false;
    }

    /**
     * Store a new comment
     */
    public function store()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $taskId = $_POST['task_id'] ?? null;
        $body = $_POST['body'] ?? null;

        if (!$userId) {
            header("Location: /login");
            exit;
        }

        // Validate input
        $validator = new Validator($_POST);
        $rules = [
            'body' => 'required|min:1',
            'task_id' => 'required'
        ];

        if (!$validator->make($rules)) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // CRITICAL SECURITY: Check access rights
        $access = $this->checkAccess($taskId, $userId);

        if (!$access) {
            http_response_code(403);
            $_SESSION['error'] = 'Access denied. You must be the project manager or a team member to comment on this task.';
            header("Location: /projects");
            exit;
        }

        // Create the comment
        $commentModel = new Comment();
        $commentId = $commentModel->create([
            'body' => $body,
            'user_id' => $userId,  // From session, NOT from form
            'task_id' => $taskId
        ]);

        if ($commentId) {
            $_SESSION['success'] = 'Comment added successfully.';
            header("Location: /tasks/show?id=" . $taskId);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to add comment. Please try again.';
            header("Location: /tasks/show?id=" . $taskId);
            exit;
        }
    }

    /**
     * Get comments for a task (typically called via AJAX or included in task view)
     */
    public function index()
    {
        $taskId = $_GET['task_id'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /login");
            exit;
        }

        if (!$taskId) {
            $_SESSION['error'] = 'Task ID is required.';
            header("Location: /projects");
            exit;
        }

        // Check access rights
        $access = $this->checkAccess($taskId, $userId);

        if (!$access) {
            http_response_code(403);
            $_SESSION['error'] = 'Access denied.';
            header("Location: /projects");
            exit;
        }

        $commentModel = new Comment();
        $comments = $commentModel->getByTask($taskId);

        // Return as JSON for AJAX requests
        if (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            header('Content-Type: application/json');
            echo json_encode(['comments' => $comments]);
            exit;
        }

        // Otherwise, render a view (or redirect to task show page)
        $this->view('comments/index', [
            'comments' => $comments,
            'task' => $access['task'],
            'project' => $access['project']
        ]);
    }

    /**
     * Delete a comment (only the author can delete their own comment)
     */
    public function destroy()
    {
        $commentId = $_POST['id'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /login");
            exit;
        }

        $commentModel = new Comment();
        $comment = $commentModel->findById($commentId);

        if (!$comment) {
            $_SESSION['error'] = 'Comment not found.';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Only the comment author can delete their comment
        if ($comment['user_id'] != $userId) {
            $_SESSION['error'] = 'You can only delete your own comments.';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $taskId = $comment['task_id'];

        if ($commentModel->delete($commentId, $userId)) {
            $_SESSION['success'] = 'Comment deleted.';
            header("Location: /tasks/show?id=" . $taskId);
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete comment. Please try again.';
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/projects'));
            exit;
        }
    }
}
