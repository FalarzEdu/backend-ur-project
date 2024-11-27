<?php

namespace Config;

class App
{
    public static array $middlewareAliases = [
        'auth:user' => \App\Middleware\Authenticate::class,
    ];
}
