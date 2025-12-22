<?php
// public/index.php

// 1. Start Session
session_start();

// 2. Production Error Handling (disable display, log errors)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// 3. Load the "Engine" (Autoloader or manual requires)
require_once '../config/database.php';
require_once '../core/Router.php';
require_once '../core/Controller.php';
require_once '../core/Model.php';

// 3. Load your specific app files (You can automate this later)
require_once '../app/Controllers/DashboardController.php';
require_once '../app/Controllers/AuthController.php';
require_once '../app/Controllers/UserController.php';

// 4. Load Routes
$router = new Router();
require_once '../routes/web.php';

// 5. Dispatch the request
$router->dispatch($_GET['url'] ?? '/');