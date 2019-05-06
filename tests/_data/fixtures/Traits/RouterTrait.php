<?php
declare(strict_types=1);

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Fixtures\Traits;

use Phalcon\Di;
use Phalcon\Http\Request;
use Phalcon\Mvc\Router;

/**
 * Routing trait
 *
 * @package Helper\Mvc
 */
trait RouterTrait
{
    /**
     * get router and set methods
     */
    protected function getRouterAndSetRoutes(array $settings, bool $defaultRoutes = true): Router
    {
        $router = $this->getRouter($defaultRoutes);

        foreach ($settings as $data) {
            $this->getRouteAndSetRouteMethod($router, $data);
        }

        return $router;
    }

    /**
     * set new router, params and get it
     */
    protected function getRouter(bool $defaultRoutes = true): Router
    {
        $router = new Router($defaultRoutes);

        $di = new Di;

        $di->setShared(
            'request',
            function () {
                return new Request;
            }
        );

        $router->setDI($di);

        return $router;
    }

    /**
     * Add method and return route
     */
    protected function getRouteAndSetRouteMethod(Router $router, array $data): \Phalcon\Mvc\Router\Route
    {
        $methodName = $data['methodName'];

        if (isset($data[1])) {
            return $router->$methodName(
                $data[0],
                $data[1]
            );
        }

        return $router->$methodName(
            $data[0]
        );
    }

    /**
     * get router and set methods and set host name
     */
    protected function getRouterAndSetRoutesAndHostNames(array $settings, bool $defaultRoutes = true): Router
    {
        $router = $this->getRouter($defaultRoutes);

        foreach ($settings as $data) {
            $route = $this->getRouteAndSetRouteMethod($router, $data);

            if (isset($data['hostname'])) {
                $route->setHostname(
                    $data['hostname']
                );
            }
        }

        return $router;
    }

    /**
     * get router and set params for
     * Phalcon\Test\Unit\Mvc\RouterTest::testUsingRouteConverters() test
     */
    protected function getRouterAndSetData(): Router
    {
        $router = $this->getRouter();

        $router->add(
            '/{controller:[a-z\-]+}/{action:[a-z\-]+}/this-is-a-country'
        )->convert(
            'controller',
            function ($controller) {
                return str_replace('-', '', $controller);
            }
        )->convert(
            'action',
            function ($action) {
                return str_replace('-', '', $action);
            }
        );

        $router->add(
            '/([A-Z]+)/([0-9]+)',
            [
                'controller' => 1,
                'action'     => 'default',
                'id'         => 2,
            ]
        )->convert(
            'controller',
            function (string $controller) {
                return strtolower($controller);
            }
        )->convert(
            'action',
            function (string $action) {
                return $action == 'default' ? 'index' : $action;
            }
        )->convert(
            'id',
            function ($id) {
                return strrev($id);
            }
        );

        return $router;
    }
}