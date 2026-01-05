<?php

require_once __DIR__ . '/../../core/Model.php';

class Message extends Model
{
    /**
     * Get all messages (for admin)
     * 
     * @param bool $unreadOnly If true, only return unread messages
     * @return array List of messages
     */
    public function getAll($unreadOnly = false)
    {
        $sql = "SELECT * FROM messages";

        if ($unreadOnly) {
            $sql .= " WHERE is_read = FALSE";
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * Find a message by ID
     * 
     * @param int $id Message ID
     * @return array|false Message data or false if not found
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM messages WHERE id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Create a new message (from contact form)
     * 
     * @param array $data Message data (name, email, message)
     * @return bool|int Returns last insert ID on success, false on failure
     */
    public function create($data)
    {
        $sql = "INSERT INTO messages (name, email, message, is_read, created_at) 
                VALUES (:name, :email, :message, FALSE, NOW())";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':message' => $data['message']
        ]);

        return $result ? $this->db->lastInsertId() : false;
    }

    /**
     * Mark a message as read
     * 
     * @param int $id Message ID
     * @return bool Success status
     */
    public function markAsRead($id)
    {
        $sql = "UPDATE messages SET is_read = TRUE WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    /**
     * Mark a message as unread
     * 
     * @param int $id Message ID
     * @return bool Success status
     */
    public function markAsUnread($id)
    {
        $sql = "UPDATE messages SET is_read = FALSE WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    /**
     * Delete a message
     * 
     * @param int $id Message ID
     * @return bool Success status
     */
    public function delete($id)
    {
        $sql = "DELETE FROM messages WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    /**
     * Count all messages
     * 
     * @return int Total message count
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) FROM messages";

        $stmt = $this->db->query($sql);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Count unread messages
     * 
     * @return int Unread message count
     */
    public function countUnread()
    {
        $sql = "SELECT COUNT(*) FROM messages WHERE is_read = FALSE";

        $stmt = $this->db->query($sql);

        return (int) $stmt->fetchColumn();
    }
}
