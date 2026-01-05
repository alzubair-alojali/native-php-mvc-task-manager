<?php

require_once __DIR__ . '/../../core/Model.php';

class Setting extends Model
{
    /**
     * Get all settings as an associative array (key => value)
     * 
     * @return array Associative array of settings
     */
    public function getAllAsAssociativeArray()
    {
        $sql = "SELECT setting_key, setting_value FROM site_settings";

        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll();

        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $settings;
    }

    /**
     * Get a single setting by key
     * 
     * @param string $key Setting key
     * @param mixed $default Default value if not found
     * @return mixed Setting value or default
     */
    public function get($key, $default = null)
    {
        $sql = "SELECT setting_value FROM site_settings WHERE setting_key = :key LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':key' => $key]);

        $result = $stmt->fetch();

        return $result ? $result['setting_value'] : $default;
    }

    /**
     * Set a single setting (insert or update)
     * 
     * @param string $key Setting key
     * @param string $value Setting value
     * @return bool Success status
     */
    public function set($key, $value)
    {
        // Check if setting exists
        $existing = $this->get($key);

        if ($existing !== null) {
            // Update existing
            $sql = "UPDATE site_settings SET setting_value = :value, updated_at = NOW() WHERE setting_key = :key";
        } else {
            // Insert new
            $sql = "INSERT INTO site_settings (setting_key, setting_value, updated_at) VALUES (:key, :value, NOW())";
        }

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':key' => $key, ':value' => $value]);
    }

    /**
     * Update multiple settings at once
     * 
     * @param array $data Associative array of key => value pairs
     * @return bool Success status (true if all updates succeeded)
     */
    public function updateBatch($data)
    {
        $success = true;

        foreach ($data as $key => $value) {
            if (!$this->set($key, $value)) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Delete a setting by key
     * 
     * @param string $key Setting key
     * @return bool Success status
     */
    public function delete($key)
    {
        $sql = "DELETE FROM site_settings WHERE setting_key = :key";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':key' => $key]);
    }

    /**
     * Get all settings as raw rows
     * 
     * @return array List of settings with id, key, value, updated_at
     */
    public function getAll()
    {
        $sql = "SELECT * FROM site_settings ORDER BY setting_key ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }
}
