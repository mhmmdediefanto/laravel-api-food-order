<?php

use App\Http\Middleware\AbleCreateItem;
use App\Http\Middleware\AbleCreateOrder;
use App\Http\Middleware\AbleCreateUser;
use App\Http\Middleware\AbleFinishOrder;
use App\Http\Middleware\AblePayOrder;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'able-create-order' => AbleCreateOrder::class,
            'able-finish-order' => AbleFinishOrder::class,
            'able-create-user' => AbleCreateUser::class,
            'able-create-item' => AbleCreateItem::class,
            'able-pay-order' => AblePayOrder::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
