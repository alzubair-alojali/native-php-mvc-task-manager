<?php

require_once __DIR__ . '/../../../core/Validator.php';

class CreateTaskRequest
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
            'status' => 'in:pending,in_progress,completed',
            'priority' => 'in:low,medium,high',
            'due_date' => 'date',
            'assigned_to' => 'exists:users,id'
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
