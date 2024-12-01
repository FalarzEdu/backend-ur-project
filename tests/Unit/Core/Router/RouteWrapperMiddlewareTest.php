<?php

namespace Tests\Unit\Core\Router;

use Core\Http\Middleware\Middleware;
use Core\Router\Route;
use Core\Router\Router;
use Core\Router\RouteWrapperMiddleware;
use PHPUnit\Framework\TestCase as FrameworkTestCase;
use Tests\Unit\Core\Router\MockController;

class RouteWrapperMiddlewareTest extends FrameworkTestCase
{
    public function test_group_should_add_middleware_to_routes(): void
    {
        $middlewareName = 'auth:user';
        $explodedMiddleware = explode(
            separator: ':',
            string: $middlewareName
        );

        $name = $explodedMiddleware[0];
        $roleRestriction = $explodedMiddleware[1];

        $routeWrapperMiddleware = new RouteWrapperMiddleware($name, roleRestriction: $roleRestriction);
        $routeSizeBefore = Router::getInstance()->getRouteSize();

        $routeWrapperMiddleware->group(function () {
            Route::get('/home', [MockController::class, 'index'])->name('home');
        });

        $routeSizeAfter = Router::getInstance()->getRouteSize();

        for ($i = $routeSizeBefore; $i < $routeSizeAfter; $i++) {
            $route = Router::getInstance()->getRoute($i);

            $reflection = new \ReflectionObject($route);
            $property = $reflection->getProperty('middlewares');
            $property->setAccessible(true);

            $middlewares = $property->getValue($route);
            $this->assertInstanceOf(Middleware::class, $middlewares[0]);
        }
    }
}
