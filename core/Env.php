<?php
/**
 * Environment Variable Loader
 * 
 * Handles loading .env files for local development
 * and falls back to system environment variables for production.
 */
class Env
{
    /**
     * Load environment variables from a .env file
     * 
     * @param string $path Path to the .env file
     * @return void
     */
    public static function load($path)
    {
        // In production (Docker/Render), .env file may not exist
        // The app will use system-level environment variables instead
        if (!file_exists($path)) {
            return; // Silently return - rely on server environment variables
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);

                $name = trim($name);
                $value = trim($value);

                // Remove surrounding quotes
                $value = trim($value, '"\'');

                // Set in both $_ENV and $_SERVER
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;

                // Also set via putenv for getenv() compatibility
                putenv("$name=$value");
            }
        }
    }

    /**
     * Get an environment variable with fallback support
     * 
     * Checks in order: $_ENV, getenv(), then returns default
     * 
     * @param string $key The environment variable name
     * @param mixed $default Default value if not found
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // Check $_ENV first (set by load() method)
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }

        // Check system environment (Docker, Render, etc.)
        $value = getenv($key);
        if ($value !== false && $value !== '') {
            return $value;
        }

        // Check $_SERVER as fallback
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return $_SERVER[$key];
        }

        // Return default if not found anywhere
        return $default;
    }
}

/**
 * Get the application base URL
 * Returns empty string for production (root deployment)
 * Returns '/web_final_project/public' for local development
 * 
 * @return string
 */
function base_url()
{
    // Load env if not already loaded
    static $loaded = false;
    if (!$loaded) {
        Env::load(__DIR__ . '/../.env');
        $loaded = true;
    }

    return Env::get('APP_URL', '');
}

/**
 * Generate a full URL path
 * 
 * @param string $path The path (e.g., '/login', '/dashboard')
 * @return string Full URL with base
 */
function url($path = '')
{
    $base = base_url();

    // Ensure path starts with /
    if ($path && $path[0] !== '/') {
        $path = '/' . $path;
    }

    return $base . $path;
}