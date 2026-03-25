<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/incidentdashboard', function () {
    return view('homepage');;
});

// Route::view('/incidentdashboard', 'homepage')->name('incidentdashboard');

Route::view('/incidentdashboard', 'homepage')
    ->middleware(['auth']) 
    ->name('incidentdashboard');

Route::get('/homepage',function(){

});
require __DIR__.'/auth.php';