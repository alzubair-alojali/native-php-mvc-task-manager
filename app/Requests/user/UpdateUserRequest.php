<?php

require_once __DIR__ . '/../../../core/Validator.php';

class UpdateUserRequest
{
    protected $validator;
    protected $userId;

    public function __construct($userId = null)
    {
        $this->validator = new Validator($_POST);
        $this->userId = $userId;
    }

    public function validate()
    {
        $rules = [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email'
        ];

        // Only validate password if provided
        if (!empty($_POST['password'])) {
            $rules['password'] = 'min:6';
        }

        if (!$this->validator->make($rules)) {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        return true;
    }
}
