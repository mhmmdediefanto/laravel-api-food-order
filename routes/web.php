<?php

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $order = Order::find(21);
    return $order->sumPriceOrder();
});
