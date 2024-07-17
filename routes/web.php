<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('{any?}', function() {
//    return view('application');
//})->where('any', '.*');

Route::get('/partner/dashboard', function () {
    return Inertia::render('dashboards/crm');
});

Route::get('/login', function () {
    return Inertia::render('login');
});