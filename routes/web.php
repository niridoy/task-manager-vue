<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


//user router list
    Route::prefix('dashboard')->group(function(){
        Route::name('user.')->group(function(){
            Route::get('/','Backend\User\UserController@index')->name('dashboard');
        });
    });

// Route::get('/login', function () {
//     return view('login');
// });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// });
