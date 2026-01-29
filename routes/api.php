<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', function (Request $request) {
    return "test";
});

Route::post('signup', function (Request $request) {
    return "test";
});

Route::get('profile', function (Request $request) {
    return "test";
});
