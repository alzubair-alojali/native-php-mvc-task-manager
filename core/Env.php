<?php
class Env {
    public static function load($path) {
        if (!file_exists($path)) {
            throw new Exception("ملف .env غير موجود في المسار: $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                
                $name = trim($name);
                $value = trim($value);

                $value = trim($value, '"\'');


                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}