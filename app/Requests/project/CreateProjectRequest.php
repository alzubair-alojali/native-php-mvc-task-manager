<?php

require_once __DIR__ . '/../../../core/Validator.php';

class CreateProjectRequest
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator($_POST);
    }

    public function validate()
    {
        $rules = [
            'title' => 'required|min:3|max:100',
            'deadline' => 'required'
        ];

        if (!$this->validator->make($rules)) {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Additional validation: deadline must be a valid future date
        $deadline = $_POST['deadline'] ?? null;
        if ($deadline && strtotime($deadline) < strtotime('today')) {
            $_SESSION['errors']['deadline'] = 'The deadline must be a future date.';
            $_SESSION['old'] = $_POST;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        return true;
    }
}
