<?php

class Model {
    protected $db;

    public function __construct() {
        global $pdo;
        if (!isset($pdo)) {
            die("Error: Database connection ($pdo) not found. Please ensure 'config/database.php' is included in 'index.php'.");
        }
        $this->db = $pdo;
    }
}