<?php

class Router {
    protected $routes = [];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch($uri) {
        $uri = trim($uri, '/');

        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes[$method])) {

            $action = explode('@', $this->routes[$method][$uri]);

            $controllerName = $action[0];
            $methodName = $action[1];

            require_once "../app/Controllers/$controllerName.php";

            $controller = new $controllerName();
            $controller->$methodName();

        } else {
            echo "404 - Page Not Found (عذراً الصفحة غير موجودة)";
        }
    }
}