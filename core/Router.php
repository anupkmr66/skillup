<?php
/**
 * Router Class
 * Handles URL routing and middleware
 */
class Router
{
    private $routes = [];
    private $middleware = [];

    /**
     * Add GET route
     * Supports both formats:
     * - get($uri, 'Controller@method', $middleware)
     * - get($uri, 'Controller', 'method', $middleware)
     */
    public function get($uri, $controller, $action = null, $middleware = [])
    {
        // If action is an array, it's actually middleware (Controller@method format)
        if (is_array($action)) {
            $middleware = $action;
            $action = null;
        }

        $this->addRoute('GET', $uri, $controller, $action, $middleware);
    }

    /**
     * Add POST route
     * Supports both formats:
     * - post($uri, 'Controller@method', $middleware)
     * - post($uri, 'Controller', 'method', $middleware)
     */
    public function post($uri, $controller, $action = null, $middleware = [])
    {
        // If action is an array, it's actually middleware (Controller@method format)
        if (is_array($action)) {
            $middleware = $action;
            $action = null;
        }

        $this->addRoute('POST', $uri, $controller, $action, $middleware);
    }

    /**
     * Add route
     */
    private function addRoute($method, $uri, $controller, $action, $middleware = [])
    {
        // Parse Controller@method syntax
        if (strpos($controller, '@') !== false && $action === null) {
            list($controller, $action) = explode('@', $controller);
        }

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    /**
     * Dispatch route
     */
    public function dispatch()
    {
        $requestUri = $this->getRequestUri();
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchRoute($route['uri'], $requestUri, $params)) {
                // Execute middleware
                foreach ($route['middleware'] as $middleware) {
                    // Skip 'auth' placeholder - actual authentication is handled in controllers
                    if ($middleware === 'auth') {
                        continue;
                    }

                    if (class_exists($middleware)) {
                        $middlewareClass = new $middleware();
                        if (!$middlewareClass->handle()) {
                            return;
                        }
                    }
                }

                // Execute controller action
                $controllerClass = $route['controller'];
                $action = $route['action'];

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        call_user_func_array([$controller, $action], $params);
                        return;
                    }
                }

                $this->notFound();
                return;
            }
        }

        $this->notFound();
    }

    /**
     * Match route pattern
     */
    private function matchRoute($routeUri, $requestUri, &$params = [])
    {
        $params = [];

        // Convert route pattern to regex
        $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $routeUri);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $requestUri, $matches)) {
            array_shift($matches); // Remove full match
            $params = $matches;
            return true;
        }

        return false;
    }

    /**
     * Get request URI
     */
    private function getRequestUri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove base path if in subdirectory
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }

        return rtrim($uri, '/') ?: '/';
    }

    /**
     * 404 Not Found
     */
    private function notFound()
    {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        exit;
    }
}
