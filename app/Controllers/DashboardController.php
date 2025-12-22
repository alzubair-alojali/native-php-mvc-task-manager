<?php

require_once '../core/Controller.php';
require_once '../app/Models/Project.php';
require_once '../app/Models/Task.php';
require_once '../app/Models/ProjectMember.php';

class DashboardController extends Controller
{
    public function index()
    {
        $isLoggedIn = isset($_SESSION['user_id']);
        $userId = $_SESSION['user_id'] ?? null;

        // Default data for guests
        $data = [
            'title' => 'Dashboard - Artisans Task Manager',
            'isLoggedIn' => $isLoggedIn,
            'username' => $isLoggedIn ? $_SESSION['user_name'] : 'Guest'
        ];

        // If logged in, fetch dashboard statistics
        if ($isLoggedIn && $userId) {
            $projectModel = new Project();
            $taskModel = new Task();
            $memberModel = new ProjectMember();

            // ==================== COUNTERS (Stats) ====================

            // Total projects where user is the Manager
            $totalProjects = $projectModel->countByManager($userId);

            // Active projects (status = 'active')
            $activeProjects = $projectModel->countActiveByManager($userId);

            // Pending tasks assigned to user
            $pendingTasks = $taskModel->countPendingByUser($userId);

            // In-progress tasks assigned to user
            $inProgressTasks = $taskModel->countInProgressByUser($userId);

            // Tasks created by user (as manager)
            $totalTasksCreated = $taskModel->countByCreator($userId);

            // ==================== RECENT ACTIVITY ====================

            // Last 5 projects created by user
            $recentProjects = $projectModel->getRecentByManager($userId, 5);

            // Last 5 tasks assigned to user (ordered by due date)
            $recentTasks = $taskModel->getRecentAssignedToUser($userId, 5);

            // Projects user is a member of (not manager)
            $memberProjects = $memberModel->getProjectsByUser($userId);

            // ==================== BUILD DATA ARRAY ====================

            $data['stats'] = [
                'total_projects' => $totalProjects,
                'active_projects' => $activeProjects,
                'pending_tasks' => $pendingTasks,
                'in_progress_tasks' => $inProgressTasks,
                'total_tasks_created' => $totalTasksCreated,
                'member_projects' => count($memberProjects)
            ];

            $data['recent_projects'] = $recentProjects;
            $data['recent_tasks'] = $recentTasks;
            $data['member_projects'] = $memberProjects;
        }

        $this->view('dashboard/index', $data);
    }
}