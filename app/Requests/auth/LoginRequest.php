<?php

require_once __DIR__ . '/../../../core/Validator.php';

class LoginRequest
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator($_POST);
    }

    public function validate()
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
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