<?php

require_once __DIR__ . '/../../../core/Validator.php';

class RegisterRequest
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator($_POST);
    }

    public function validate()
    {
        $rules = [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ];

        if (!$this->validator->make($rules)) {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        return true;
    }
}
