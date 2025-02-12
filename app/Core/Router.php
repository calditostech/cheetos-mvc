<?php

namespace App\Core;

class Router {
    protected array $routes = [];

    public function get(string $route, $callback) {
        $this->routes['GET'][$route] = $callback;
    }

    public function post(string $route, $callback) {
        $this->routes['POST'][$route] = $callback;
    }

    public function run() {
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $uri = explode('?', $uri)[0];
        $uri = trim($uri, '/');
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "Página não encontrada!";
            return;
        }

        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }

                return call_user_func_array($callback, $params);
            }
        }

        http_response_code(404);
        echo "Página não encontrada!";
    }
}

