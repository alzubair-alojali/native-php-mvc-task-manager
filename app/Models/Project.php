<?php

require_once __DIR__ . '/../../core/Model.php';

class Project extends Model
{
    /**
     * Create a new project
     * 
     * @param array $data Project data (title, description, deadline, status, manager_id)
     * @return bool|int Returns last insert ID on success, false on failure
     */
    public function create($data)
    {
        $sql = "INSERT INTO projects (title, description, deadline, status, manager_id, created_at, updated_at) 
                VALUES (:title, :description, :deadline, :status, :manager_id, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':deadline' => $data['deadline'],
            ':status' => $data['status'] ?? 'pending',
            ':manager_id' => $data['manager_id']
        ]);

        return $result ? $this->db->lastInsertId() : false;
    }

    /**
     * Get all projects for a specific manager
     * 
     * @param int $managerId The manager's user ID
     * @return array List of projects
     */
    public function getAllByManager($managerId)
    {
        $sql = "SELECT * FROM projects WHERE manager_id = :manager_id ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':manager_id' => $managerId]);

        return $stmt->fetchAll();
    }

    /**
     * Find a project by ID (with manager verification)
     * 
     * @param int $id Project ID
     * @param int|null $managerId Optional manager ID for ownership verification
     * @return array|false Project data or false if not found
     */
    public function findById($id, $managerId = null)
    {
        if ($managerId !== null) {
            // Security: Only return project if user is the manager
            $sql = "SELECT * FROM projects WHERE id = :id AND manager_id = :manager_id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id, ':manager_id' => $managerId]);
        } else {
            $sql = "SELECT * FROM projects WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
        }

        return $stmt->fetch();
    }

    /**
     * Update a project
     * 
     * @param int $id Project ID
     * @param array $data Updated project data
     * @param int $managerId Manager ID for ownership verification
     * @return bool Success status
     */
    public function update($id, $data, $managerId)
    {
        $sql = "UPDATE projects 
                SET title = :title, 
                    description = :description, 
                    deadline = :deadline, 
                    status = :status,
                    updated_at = NOW()
                WHERE id = :id AND manager_id = :manager_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':deadline' => $data['deadline'],
            ':status' => $data['status'] ?? 'pending',
            ':id' => $id,
            ':manager_id' => $managerId
        ]);
    }

    /**
     * Delete a project (only if user is the manager)
     * 
     * @param int $id Project ID
     * @param int $managerId Manager ID for ownership verification
     * @return bool Success status
     */
    public function delete($id, $managerId)
    {
        $sql = "DELETE FROM projects WHERE id = :id AND manager_id = :manager_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id, ':manager_id' => $managerId]);
    }

    // ==================== DASHBOARD HELPER METHODS ====================

    /**
     * Count total projects for a manager
     * 
     * @param int $managerId Manager's user ID
     * @return int Project count
     */
    public function countByManager($managerId)
    {
        $sql = "SELECT COUNT(*) FROM projects WHERE manager_id = :manager_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':manager_id' => $managerId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Count active projects for a manager
     * 
     * @param int $managerId Manager's user ID
     * @return int Active project count
     */
    public function countActiveByManager($managerId)
    {
        $sql = "SELECT COUNT(*) FROM projects WHERE manager_id = :manager_id AND status = 'active'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':manager_id' => $managerId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Get recent projects for a manager
     * 
     * @param int $managerId Manager's user ID
     * @param int $limit Number of projects to return
     * @return array Recent projects
     */
    public function getRecentByManager($managerId, $limit = 5)
    {
        $sql = "SELECT * FROM projects WHERE manager_id = :manager_id 
                ORDER BY created_at DESC LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':manager_id', $managerId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Search projects by title
     * 
     * @param int $managerId Manager user ID
     * @param string $query Search query
     * @return array List of matching projects
     */
    public function search($managerId, $query)
    {
        $sql = "SELECT * FROM projects 
                WHERE manager_id = :manager_id 
                AND title LIKE :query 
                ORDER BY created_at DESC 
                LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':manager_id' => $managerId,
            ':query' => '%' . $query . '%'
        ]);

        return $stmt->fetchAll();
    }
}
