<?php

require_once __DIR__ . '/../../core/Model.php';

class Service extends Model
{
    /**
     * Get all services
     * 
     * @return array List of services
     */
    public function getAll()
    {
        $sql = "SELECT * FROM services ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Find a service by ID
     * 
     * @param int $id Service ID
     * @return array|false Service data or false if not found
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM services WHERE id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Create a new service
     * 
     * @param array $data Service data (title, description, icon)
     * @return bool|int Returns last insert ID on success, false on failure
     */
    public function create($data)
    {
        $sql = "INSERT INTO services (title, description, icon, created_at) 
                VALUES (:title, :description, :icon, NOW())";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':icon' => $data['icon'] ?? 'fa-star'
        ]);

        return $result ? $this->db->lastInsertId() : false;
    }

    /**
     * Update a service
     * 
     * @param int $id Service ID
     * @param array $data Updated service data
     * @return bool Success status
     */
    public function update($id, $data)
    {
        $sql = "UPDATE services 
                SET title = :title, 
                    description = :description, 
                    icon = :icon
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':icon' => $data['icon'] ?? 'fa-star',
            ':id' => $id
        ]);
    }

    /**
     * Delete a service
     * 
     * @param int $id Service ID
     * @return bool Success status
     */
    public function delete($id)
    {
        $sql = "DELETE FROM services WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    /**
     * Count total services
     * 
     * @return int Service count
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) FROM services";

        $stmt = $this->db->query($sql);

        return (int) $stmt->fetchColumn();
    }
}
