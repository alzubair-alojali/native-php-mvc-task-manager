<?php

require_once '../core/Controller.php';
require_once '../app/Models/Project.php';
require_once '../app/Models/Task.php';

class SearchController extends Controller
{
    /**
     * Search for projects and tasks
     * If query is empty, show all recent projects and tasks
     */
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /web_final_project/public/login");
            exit;
        }

        $query = trim($_GET['q'] ?? '');

        $projectModel = new Project();
        $taskModel = new Task();

        if (!empty($query)) {
            // Search with query - filter by title
            $projects = $projectModel->search($userId, $query);
            $tasks = $taskModel->search($userId, $query);
        } else {
            // Empty query - show ALL recent projects and tasks (limit 20 each)
            $projects = $projectModel->getRecentByManager($userId, 20);
            $tasks = $taskModel->getRecentAssignedToUser($userId, 20);
        }

        $this->view('search/results', [
            'query' => $query,
            'projects' => $projects,
            'tasks' => $tasks,
            'showAll' => empty($query)
        ]);
    }
}
