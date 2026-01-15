<?php

class Router
{
    public function dispatch(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '';
        $path = trim($path, '/');

        $basePath = $this->basePath();
        if ($basePath !== '' && str_starts_with($path, $basePath)) {
            $path = trim(substr($path, strlen($basePath)), '/');
        }
        $segments = $path === '' ? [] : explode('/', $path);
        
        // Mặc định là HomeController và action index
        $controllerName = ucfirst($segments[0] ?? 'home') . 'Controller';
        $action = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        // Sửa logic: Nếu class KHÔNG tồn tại thì báo lỗi
        if (!class_exists($controllerName)) {
            $this->notFound("Controller '$controllerName' not found");
            return;
        }

        $controller = new $controllerName();

        // Sửa logic: Nếu method KHÔNG tồn tại thì báo lỗi
        if (!method_exists($controller, $action)) {
            $this->notFound("Method '$action' not found in $controllerName");
            return;
        }

        call_user_func_array([$controller, $action], $params);
    }

    public function basePath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        return trim(dirname($scriptName), '/');
    }

    public function notFound($message): void
    {
        http_response_code(404);
        echo "<h1 style ='color:red;'>404 Not Found: $message</h1>";
    }
}