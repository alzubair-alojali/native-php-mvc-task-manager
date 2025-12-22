<?php

// =============================================================================
// ARTISANS TASK MANAGER - ROUTE DEFINITIONS
// =============================================================================
// All routes are organized by module with clear grouping.
// HTTP Methods: GET for viewing, POST for creating/modifying/deleting
// =============================================================================

// -----------------------------------------------------------------------------
// PUBLIC PAGES (Guest Only)
// -----------------------------------------------------------------------------
$router->get('', 'HomeController@index');

// -----------------------------------------------------------------------------
// DASHBOARD (Auth Required)
// -----------------------------------------------------------------------------
$router->get('dashboard', 'DashboardController@index');

// -----------------------------------------------------------------------------
// AUTHENTICATION
// -----------------------------------------------------------------------------
$router->get('register', 'AuthController@showRegisterForm');
$router->post('register', 'AuthController@register');
$router->get('login', 'AuthController@showLoginForm');
$router->post('login', 'AuthController@login');
$router->get('logout', 'AuthController@logout');

// -----------------------------------------------------------------------------
// USER MANAGEMENT (Admin)
// -----------------------------------------------------------------------------
$router->get('users', 'UserController@index');
$router->get('users/create', 'UserController@create');
$router->post('users/create', 'UserController@store');
$router->get('users/edit', 'UserController@edit');
$router->post('users/edit', 'UserController@update');
$router->post('users/delete', 'UserController@destroy');

// -----------------------------------------------------------------------------
// PROJECTS
// -----------------------------------------------------------------------------
$router->get('projects', 'ProjectController@index');
$router->get('projects/create', 'ProjectController@create');
$router->post('projects/create', 'ProjectController@store');
$router->get('projects/show', 'ProjectController@show');
$router->get('projects/edit', 'ProjectController@edit');
$router->post('projects/edit', 'ProjectController@update');
$router->post('projects/delete', 'ProjectController@destroy');

// -----------------------------------------------------------------------------
// PROJECT MEMBERS (Team Management)
// -----------------------------------------------------------------------------
$router->get('projects/members', 'ProjectMemberController@index');
$router->post('projects/members/add', 'ProjectMemberController@store');
$router->post('projects/members/remove', 'ProjectMemberController@destroy');

// -----------------------------------------------------------------------------
// TASKS
// -----------------------------------------------------------------------------
$router->get('tasks', 'TaskController@index');
$router->get('tasks/create', 'TaskController@create');
$router->post('tasks/store', 'TaskController@store');
$router->get('tasks/show', 'TaskController@show');
$router->get('tasks/edit', 'TaskController@edit');
$router->post('tasks/update', 'TaskController@update');
$router->post('tasks/delete', 'TaskController@destroy');
$router->post('tasks/update-status', 'TaskController@updateStatus');

// -----------------------------------------------------------------------------
// COMMENTS
// -----------------------------------------------------------------------------
$router->get('comments', 'CommentController@index');
$router->post('comments/store', 'CommentController@store');
$router->post('comments/delete', 'CommentController@destroy');

// -----------------------------------------------------------------------------
// SEARCH
// -----------------------------------------------------------------------------
$router->get('search', 'SearchController@index');

// -----------------------------------------------------------------------------
// PROFILE
// -----------------------------------------------------------------------------
$router->get('profile', 'ProfileController@index');
$router->post('profile/update', 'ProfileController@update');

// -----------------------------------------------------------------------------
// MY TASKS (User's assigned tasks across all projects)
// -----------------------------------------------------------------------------
$router->get('tasks/my-tasks', 'TaskController@myTasks');