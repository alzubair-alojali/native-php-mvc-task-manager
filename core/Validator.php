<?php

class Validator
{
    protected $errors = [];
    protected $data;
    protected $db;

    public function __construct($data)
    {
        $this->data = $data;
        global $pdo;
        $this->db = $pdo;
    }

    public function make($rules)
    {
        foreach ($rules as $field => $ruleString) {
            $ruleArray = explode('|', $ruleString);
            foreach ($ruleArray as $rule) {
                $params = [];
                if (strpos($rule, ':') !== false) {
                    list($rule, $paramStr) = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                }
                $value = $this->data[$field] ?? null;

                if (!$this->validateRule($field, $value, $rule, $params)) {
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    protected function validateRule($field, $value, $rule, $params)
    {
        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->errors[$field] = "The $field field is required.";
                    return false;
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = "The $field must be a valid email address.";
                    return false;
                }
                break;

            case 'min':
                if (strlen($value) < $params[0]) {
                    $this->errors[$field] = "The $field must be at least {$params[0]} characters.";
                    return false;
                }
                break;

            case 'max':
                if (strlen($value) > $params[0]) {
                    $this->errors[$field] = "The $field must not exceed {$params[0]} characters.";
                    return false;
                }
                break;

            case 'unique':
                $table = $params[0];
                $column = $params[1];

                // Security: Whitelist allowed tables and columns
                $allowedTables = ['users', 'projects', 'tasks'];
                $allowedColumns = ['email', 'name', 'title', 'slug'];

                if (!in_array($table, $allowedTables) || !in_array($column, $allowedColumns)) {
                    $this->errors[$field] = "Invalid validation configuration.";
                    return false;
                }

                $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE $column = ?");
                $stmt->execute([$value]);

                if ($stmt->fetchColumn() > 0) {
                    $this->errors[$field] = "The $field has already been taken.";
                    return false;
                }
                break;

            case 'in':
                // Validate that value is in a list of allowed values (for ENUM fields)
                if (!empty($value) && !in_array($value, $params)) {
                    $allowed = implode(', ', $params);
                    $this->errors[$field] = "The $field must be one of: $allowed.";
                    return false;
                }
                break;

            case 'exists':
                // Validate that value exists in a table (for foreign keys)
                if (!empty($value)) {
                    $table = $params[0];
                    $column = $params[1] ?? 'id';

                    // Security: Whitelist allowed tables
                    $allowedTables = ['users', 'projects', 'tasks'];
                    if (!in_array($table, $allowedTables)) {
                        $this->errors[$field] = "Invalid validation configuration.";
                        return false;
                    }

                    $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE $column = ?");
                    $stmt->execute([$value]);

                    if ($stmt->fetchColumn() == 0) {
                        $this->errors[$field] = "The selected $field is invalid.";
                        return false;
                    }
                }
                break;

            case 'date':
                // Validate date format
                if (!empty($value)) {
                    $d = DateTime::createFromFormat('Y-m-d', $value);
                    if (!$d || $d->format('Y-m-d') !== $value) {
                        $this->errors[$field] = "The $field must be a valid date (YYYY-MM-DD).";
                        return false;
                    }
                }
                break;

            case 'date_after_today':
                // Validate date is in the future (tomorrow onwards)
                if (!empty($value)) {
                    $d = DateTime::createFromFormat('Y-m-d', $value);
                    $today = new DateTime('today');
                    if (!$d || $d <= $today) {
                        $this->errors[$field] = "The $field must be a future date.";
                        return false;
                    }
                }
                break;
        }
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}