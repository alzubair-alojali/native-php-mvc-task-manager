<?php

require_once __DIR__ . '/../../core/Model.php';

class User extends Model
{


    public function getAll()
    {
        $sql = "SELECT * FROM users";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function create($data)
    {
        // Check all required fields are present
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            return false;
        }

        // Check if email already exists
        if ($this->findByEmail($data['email'])) {
            return false;
        }

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

        $stmt = $this->db->prepare($sql);

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $hashedPassword
        ]);
    }


    public function update($id, $data)
    {
        $fields = "name = :name, email = :email";
        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':id' => $id
        ];

        if (!empty($data['password'])) {
            $fields .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (isset($data['role'])) {
            $fields .= ", role = :role";
            $params[':role'] = $data['role'];
        }

        $sql = "UPDATE users SET $fields WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([':email' => $email]);

        return $stmt->fetch();
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    }
}