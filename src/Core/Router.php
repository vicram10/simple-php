<?php

namespace Src\Core;

use Db\Core\DbDriver;

class Router {
    private static $routes = [];

    static function get($uri, $callback) {
        self::$routes['GET'][$uri] = $callback;
    }

    static function post($uri, $callback) {
        self::$routes['POST'][$uri] = $callback;
    }

    static function dispatch(DbDriver $dbDriver): void {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Limpiar la URI en caso de que esté en un subdirectorio
        $script_name = dirname($_SERVER['SCRIPT_NAME']);
        if ($script_name !== '/') {
            $uri = str_replace($script_name, '', $uri);
        }

        $uri = trim($uri, '/');

        if ($uri === '') {
            $uri = '/';
        }

        if (isset(self::$routes[$method][$uri])) {
            $callback = self::$routes[$method][$uri];

            if (is_callable($callback)) {
                // Closure o función anónima
                call_user_func($callback);
            } elseif (is_array($callback) && count($callback) === 2) {
                // Llamar a un método de una clase
                $controller = new $callback[0]($dbDriver); // Instanciar la clase
                $method = $callback[1];

                if (method_exists($controller, $method)) {
                    $template = call_user_func([$controller, $method]);
                    echo $template;
                } else {
                    http_response_code(500);
                    echo "Error: Método '$method' no encontrado en la clase " . $callback[0];
                }
            } else {
                http_response_code(500);
                echo "Error: Ruta mal configurada";
            }
        } else {
            http_response_code(404);
            echo "404 - Not Found";
        }
    }
}
