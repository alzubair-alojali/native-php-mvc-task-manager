<?php

require_once __DIR__ . '/../../core/Model.php';

class Task extends Model
{
    /**
     * Create a new task
     * 
     * @param array $data Task data
     * @return bool|int Returns last insert ID on success, false on failure
     */
    public function create($data)
    {
        $sql = "INSERT INTO tasks (title, description, due_date, status, priority, project_id, assigned_to, created_by, created_at, updated_at) 
                VALUES (:title, :description, :due_date, :status, :priority, :project_id, :assigned_to, :created_by, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':due_date' => $data['due_date'] ?? null,
            ':status' => $data['status'] ?? 'pending',
            ':priority' => $data['priority'] ?? 'medium',
            ':project_id' => $data['project_id'],
            ':assigned_to' => $data['assigned_to'] ?? null,
            ':created_by' => $data['created_by']
        ]);

        return $result ? $this->db->lastInsertId() : false;
    }

    /**
     * Get all tasks for a specific project
     * 
     * @param int $projectId The project ID
     * @return array List of tasks
     */
    public function getByProject($projectId)
    {
        $sql = "SELECT t.*, u.name as assigned_user_name 
                FROM tasks t 
                LEFT JOIN users u ON t.assigned_to = u.id 
                WHERE t.project_id = :project_id 
                ORDER BY t.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':project_id' => $projectId]);

        return $stmt->fetchAll();
    }

    /**
     * Find a task by ID
     * 
     * @param int $id Task ID
     * @return array|false Task data or false if not found
     */
    public function findById($id)
    {
        $sql = "SELECT t.*, u.name as assigned_user_name 
                FROM tasks t 
                LEFT JOIN users u ON t.assigned_to = u.id 
                WHERE t.id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Update task status
     * 
     * @param int $id Task ID
     * @param string $status New status (pending, in_progress, completed)
     * @return bool Success status
     */
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE tasks SET status = :status, updated_at = NOW() WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    /**
     * Update a task
     * 
     * @param int $id Task ID
     * @param array $data Updated task data
     * @return bool Success status
     */
    public function update($id, $data)
    {
        $sql = "UPDATE tasks 
                SET title = :title, 
                    description = :description, 
                    due_date = :due_date, 
                    status = :status,
                    priority = :priority,
                    assigned_to = :assigned_to,
                    updated_at = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':due_date' => $data['due_date'] ?? null,
            ':status' => $data['status'] ?? 'pending',
            ':priority' => $data['priority'] ?? 'medium',
            ':assigned_to' => $data['assigned_to'] ?? null,
            ':id' => $id
        ]);
    }

    /**
     * Delete a task
     * 
     * @param int $id Task ID
     * @return bool Success status
     */
    public function delete($id)
    {
        $sql = "DELETE FROM tasks WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    /**
     * Get the project ID for a task (for ownership verification)
     * 
     * @param int $taskId Task ID
     * @return int|null Project ID or null if not found
     */
    public function getProjectId($taskId)
    {
        $sql = "SELECT project_id FROM tasks WHERE id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $taskId]);

        $result = $stmt->fetch();
        return $result ? $result['project_id'] : null;
    }

    // ==================== DASHBOARD HELPER METHODS ====================

    /**
     * Count pending tasks assigned to a user
     * 
     * @param int $userId User ID
     * @return int Pending task count
     */
    public function countPendingByUser($userId)
    {
        $sql = "SELECT COUNT(*) FROM tasks WHERE assigned_to = :user_id AND status = 'pending'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Count in-progress tasks assigned to a user
     * 
     * @param int $userId User ID
     * @return int In-progress task count
     */
    public function countInProgressByUser($userId)
    {
        $sql = "SELECT COUNT(*) FROM tasks WHERE assigned_to = :user_id AND status = 'in_progress'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Get recent tasks assigned to a user (ordered by due date)
     * 
     * @param int $userId User ID
     * @param int $limit Number of tasks to return
     * @return array Recent tasks
     */
    public function getRecentAssignedToUser($userId, $limit = 5)
    {
        $sql = "SELECT t.*, p.title as project_title 
                FROM tasks t 
                LEFT JOIN projects p ON t.project_id = p.id
                WHERE t.assigned_to = :user_id 
                ORDER BY t.due_date ASC, t.created_at DESC 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Count tasks created by a user (as manager)
     * 
     * @param int $userId User ID
     * @return int Task count
     */
    public function countByCreator($userId)
    {
        $sql = "SELECT COUNT(*) FROM tasks WHERE created_by = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Get all tasks assigned to a specific user (across all projects)
     * 
     * @param int $userId User ID
     * @return array List of tasks with project info
     */
    public function getAssignedToUser($userId)
    {
        $sql = "SELECT t.*, p.title as project_title, u.name as assigned_user_name 
                FROM tasks t 
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id 
                WHERE t.assigned_to = :user_id 
                ORDER BY 
                    CASE WHEN t.status = 'completed' THEN 1 ELSE 0 END,
                    t.due_date ASC, 
                    t.priority DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    /**
     * Search tasks by title (assigned to or created by user)
     * 
     * @param int $userId User ID
     * @param string $query Search query
     * @return array List of matching tasks
     */
    public function search($userId, $query)
    {
        $sql = "SELECT t.*, p.title as project_title 
                FROM tasks t 
                LEFT JOIN projects p ON t.project_id = p.id 
                WHERE (t.assigned_to = :user_id OR t.created_by = :user_id2) 
                AND t.title LIKE :query 
                ORDER BY t.created_at DESC 
                LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':user_id2' => $userId,
            ':query' => '%' . $query . '%'
        ]);

        return $stmt->fetchAll();
    }
}


