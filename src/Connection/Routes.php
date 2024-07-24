<?php

namespace STA\Connection;

use STA\Populate\Populate;
use STA\Storage\ProductStorage;

class Routes
{
    /**
     * Registry all routes available on the Router instance given.
     * @param Router $router The Router instance to be populated
     * @return Router The same Router instance given populated with the routes
     */
    public static function loadRoutes(Router $router): Router
    {
        $router->addRoute('/api/populate', [Populate::class, 'populate'], 'GET');
        $router->addRoute('/api/products', [ProductStorage::class, 'listProducts'], 'GET');
        $router->addRoute('/api/add', [ProductStorage::class, 'addProduct'], 'POST');
        $router->addRoute('/api/delete', [ProductStorage::class, 'deleteProducts'], 'POST');

        $router->addRoute(
            pattern: '/api/add/redirect',
            callback: [ProductStorage::class, 'addProduct'],
            type:'POST',
            homeRedirect: true);

        $router->addRoute(
            pattern: '/api/delete/redirect',
            callback: [ProductStorage::class, 'deleteProducts'],
            type: 'POST',
            homeRedirect: true);

        return $router;
    }
}
