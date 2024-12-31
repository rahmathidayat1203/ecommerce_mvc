<?php
class Router
{
    private $routes = [];
    private $basePath;
    private $params = [];

    public function __construct($basePath = '')
    {
        $this->basePath = trim($basePath, '/');
    }

    public function add($method, $path, $handler)
    {
        $pattern = $path === '/' ? '\/?' : str_replace('/', '\/', $path);
        $pattern = preg_replace('/\{([^\/]+)\}/', '([^\/]+)', $pattern);

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => trim($path, '/'),
            'pattern' => '/^' . $pattern . '$/',
            'handler' => $handler,
        ];

        return $this;
    }

    public function get($path, $handler)
    {
        return $this->add('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        return $this->add('POST', $path, $handler);
    }

    public function run()
    {
        $this->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }

    public function dispatch($requestMethod, $requestUri)
    {
        // Ambil path dari URI tanpa query string
        $requestUri = trim(parse_url($requestUri, PHP_URL_PATH), '/');

        // Hapus base path dari URI
        if ($this->basePath) {
            $basePathLength = strlen($this->basePath);
            if (substr($requestUri, 0, $basePathLength) === $this->basePath) {
                $requestUri = substr($requestUri, $basePathLength);
            }
        }

        // Normalisasi URI (hilangkan trailing slash)
        $requestUri = trim($requestUri, '/');
        $requestMethod = strtoupper($requestMethod);

        // Debugging
        // echo "Processed URI: {$requestUri}<br>";
        // echo "Method: {$requestMethod}<br>";
        // echo "Routes: <pre>" . print_r($this->routes, true) . "</pre>";

        // Cocokkan rute
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod) {
                if (preg_match($route['pattern'], $requestUri, $matches)) {
                    array_shift($matches);

                    // Ambil parameter dari rute
                    preg_match_all('/\{([^\/]+)\}/', $route['path'], $paramNames);
                    foreach ($paramNames[1] as $index => $name) {
                        if (isset($matches[$index])) {
                            $this->params[$name] = $matches[$index];
                        }
                    }

                    return $this->resolve($route['handler']);
                }
            }
        }

        // Jika tidak ada rute yang cocok
        http_response_code(404);
        die("404 Not Found: Route '{$requestUri}' not defined.");
    }




    private function resolve($handler)
    {
        if (is_callable($handler)) {
            return call_user_func($handler, $this->params);
        }

        if (is_string($handler)) {
            $parts = explode('@', $handler);
            $controllerName = $parts[0];
            $methodName = $parts[1];

            $controllerFile = __DIR__ . "/../app/controllers/{$controllerName}.php";
            if (!file_exists($controllerFile)) {
                die("File controller tidak ditemukan: {$controllerFile}");
            }

            require_once $controllerFile;
            $controller = new $controllerName();

            if (!method_exists($controller, $methodName)) {
                die("Method '{$methodName}' tidak ditemukan di controller '{$controllerName}'");
            }

            return call_user_func([$controller, $methodName], $this->params);
        }

        die("Invalid route handler.");
    }

    private function extractParamNames($path)
    {
        preg_match_all('/\{([^\/]+)\}/', $path, $matches);
        return $matches[1];
    }
}
