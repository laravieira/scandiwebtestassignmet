<?php

namespace STA\Connection;

use STA\STAException;

class Router
{
    private array $routes = array();

    /**
     * Create a Route and add it to be callable by call() method.
     *
     * The pattern can include REST API GET args like:
     * * **get string:** [s:get_name]
     * * **get int:** [i:get_name]
     * * **get float:** [f:get_name]
     * * **get bool:** [b:get_name]
     *
     * One pattern example is:
     * > /product/[s:sku]/price/[f:price]/update
     *
     * That patter will recognise paths and catch these params like:
     * 1. /product/HJ3HJ7HDF/price/12.32/update
     *      * string $sku = 'HJ3HJ7HDF';
     *      * float $price = 12.32f;
     * 2. /product/HJ3547543/price/0/update
     *      * string $sku = 'HJ3547543';
     *      * float $price = 0f;
     * @param string $pattern The pattern rule to call the route
     * @param string|array $callback The method to call when the route is called
     * @param string $type The request type to this route
     * @param bool $homeRedirect If this route will redirect to the home redirect
     */
    public function addRoute(string $pattern, string|array $callback, string $type, bool $homeRedirect = false): void
    {
        $this->routes[] = new Route($pattern, $callback, $type, $homeRedirect);
    }


    /**
     * Call a route that matches the given path with the route pattern rule
     * or return 404 Not Found error
     * @param string $path The path to be matched by a pattern rule
     */
    public function call(string $path): void
    {
        try {
            foreach ($this->routes as $route) {
                if ($route->type != $_SERVER['REQUEST_METHOD'])
                    continue;
                $params = $route->isPathEquals($path);
                if ($params) {
                    array_shift($params);
                    $route->loadParams($params);
                    $route->call();
                    return;
                }
            }
            throw new STAException('Not Found.', 404);

        }catch (STAException $e) {
            $response = new Response($e->respond(), $e->getCode());
            $response->send();
        }
    }

}