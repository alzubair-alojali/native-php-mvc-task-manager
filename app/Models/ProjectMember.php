<?php

require_once __DIR__ . '/../../core/Model.php';

class ProjectMember extends Model
{
    /**
     * Add a member to a project
     * 
     * @param int $projectId Project ID
     * @param int $userId User ID to add
     * @return bool Success status
     */
    public function addMember($projectId, $userId)
    {
        // Check if already a member (prevent duplicates)
        if ($this->isMember($projectId, $userId)) {
            return false;
        }

        $sql = "INSERT INTO project_members (project_id, user_id, joined_at) 
                VALUES (:project_id, :user_id, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':project_id' => $projectId,
            ':user_id' => $userId
        ]);
    }

    /**
     * Remove a member from a project
     * 
     * @param int $projectId Project ID
     * @param int $userId User ID to remove
     * @return bool Success status
     */
    public function removeMember($projectId, $userId)
    {
        $sql = "DELETE FROM project_members WHERE project_id = :project_id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':project_id' => $projectId,
            ':user_id' => $userId
        ]);
    }

    /**
     * Get all members of a project
     * 
     * @param int $projectId Project ID
     * @return array List of members with user details
     */
    public function getMembersByProject($projectId)
    {
        $sql = "SELECT pm.*, u.id as user_id, u.name, u.email 
                FROM project_members pm
                JOIN users u ON pm.user_id = u.id
                WHERE pm.project_id = :project_id
                ORDER BY pm.joined_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':project_id' => $projectId]);

        return $stmt->fetchAll();
    }

    /**
     * Check if a user is a member of a project
     * 
     * @param int $projectId Project ID
     * @param int $userId User ID
     * @return bool True if member, false otherwise
     */
    public function isMember($projectId, $userId)
    {
        $sql = "SELECT COUNT(*) FROM project_members 
                WHERE project_id = :project_id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':project_id' => $projectId,
            ':user_id' => $userId
        ]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Get all projects a user is a member of
     * 
     * @param int $userId User ID
     * @return array List of projects
     */
    public function getProjectsByUser($userId)
    {
        $sql = "SELECT p.*, pm.joined_at 
                FROM project_members pm
                JOIN projects p ON pm.project_id = p.id
                WHERE pm.user_id = :user_id
                ORDER BY pm.joined_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    /**
     * Get count of members in a project
     * 
     * @param int $projectId Project ID
     * @return int Member count
     */
    public function getMemberCount($projectId)
    {
        $sql = "SELECT COUNT(*) FROM project_members WHERE project_id = :project_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':project_id' => $projectId]);

        return (int) $stmt->fetchColumn();
    }
}
