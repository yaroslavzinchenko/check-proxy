<?php

use App\Http\Controllers\ProxyController;
use Illuminate\Support\Facades\Route;

Route::get('/check-proxy', function () {
    return view('check-proxy');
});

Route::post('/check-proxy', [ProxyController::class, 'checkProxy']);
