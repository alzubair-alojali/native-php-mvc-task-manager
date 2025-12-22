<?php

require_once __DIR__ . '/../../core/Model.php';

class Comment extends Model
{
    /**
     * Create a new comment
     * 
     * @param array $data Comment data (body, user_id, task_id)
     * @return bool|int Returns last insert ID on success, false on failure
     */
    public function create($data)
    {
        $sql = "INSERT INTO comments (body, user_id, task_id, created_at) 
                VALUES (:body, :user_id, :task_id, NOW())";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':body' => $data['body'],
            ':user_id' => $data['user_id'],
            ':task_id' => $data['task_id']
        ]);

        return $result ? $this->db->lastInsertId() : false;
    }

    /**
     * Get all comments for a specific task
     * 
     * @param int $taskId Task ID
     * @return array List of comments with user details
     */
    public function getByTask($taskId)
    {
        $sql = "SELECT c.*, u.name as user_name, u.email as user_email 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.task_id = :task_id
                ORDER BY c.created_at ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':task_id' => $taskId]);

        return $stmt->fetchAll();
    }

    /**
     * Find a comment by ID
     * 
     * @param int $id Comment ID
     * @return array|false Comment data or false if not found
     */
    public function findById($id)
    {
        $sql = "SELECT c.*, u.name as user_name 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Delete a comment (only by the comment author)
     * 
     * @param int $id Comment ID
     * @param int $userId User ID (for ownership verification)
     * @return bool Success status
     */
    public function delete($id, $userId)
    {
        $sql = "DELETE FROM comments WHERE id = :id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }

    /**
     * Get comment count for a task
     * 
     * @param int $taskId Task ID
     * @return int Comment count
     */
    public function getCountByTask($taskId)
    {
        $sql = "SELECT COUNT(*) FROM comments WHERE task_id = :task_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':task_id' => $taskId]);

        return (int) $stmt->fetchColumn();
    }
}
