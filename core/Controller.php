<?php

class Controller
{

    /**
     * Require authenticated user - redirects to login if not logged in
     * Use in protected controllers (Dashboard, Projects, Tasks, etc.)
     */
    protected function requireAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /web_final_project/public/login");
            exit;
        }
    }

    /**
     * Require guest (not logged in) - redirects to dashboard if already logged in
     * Use in auth controllers (Login, Register, Landing)
     */
    protected function requireGuest()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /web_final_project/public/dashboard");
            exit;
        }
    }

    public function view($view, $data = [])
    {
        extract($data);

        if (file_exists("../resources/views/$view.php")) {
            require_once "../resources/views/$view.php";
        } else {
            die("View file '$view' not found!");
        }
    }
}