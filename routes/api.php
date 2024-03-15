<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::post('/check-proxy', function () {
    return view('check-proxy');
});
