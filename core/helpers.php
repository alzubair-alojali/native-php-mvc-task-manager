<?php
// core/helpers.php
// 
// This file provides helper functions for URL generation.
// The main base_url() and url() functions are defined in core/Env.php
// This file extends with additional helpers.

/**
 * Generate a URL for static assets (CSS, JS, images).
 * This uses the url() function from Env.php
 * 
 * @param string $path Path to the asset (e.g., 'css/style.css', 'js/app.js')
 * @return string The full URL to the asset
 */
if (!function_exists('asset')) {
    function asset(string $path = ''): string
    {
        return url($path);
    }
}
