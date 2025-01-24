<?php

use App\Helpers\Translation;
use Core\Debug\Debugger;
use Core\Router\Router;

if (!function_exists('d')) 
{
    function dd(): void
    {
        Debugger::dd(...func_get_args());
    }
}

if (!function_exists('route')) 
{
    /**
     * @param string $name
     * @param mixed[] $params
     * @return string
     */
    function route(string $name, $params = []): string
    {
        return Router::getInstance()->getRoutePathByName($name, $params);
    }
}

if (!function_exists('translate')) 
{
    function translate(string $key, string $value): string
    {
        return Translation::translate(
            $key, $value
        );
    }
}

if (!function_exists(function: 'is_home_page'))
{
    function is_home_page(): bool
    {
        $home_pages = ['users.home', 'admins.home'];
        $actual_route = Router::getInstance()->getActualRoute();
        return (
            in_array(
                needle: $actual_route->getName(), 
                haystack: $home_pages
            )
        );
    }
}
