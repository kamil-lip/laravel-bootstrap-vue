<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();

    });

    Route::resource('users', 'API\UserController')->only([
        'index',
        'update',
        'show',
        'destroy',
        'store'
    ]);

    Route::get('/users/validation/rules', 'API\UserController@validationRules')->name('users.validation-rules');

    Route::resource('books', 'API\BookController')->only([
        'index',
        'update',
        'show',
        'destroy',
        'store'
    ]);

    Route::get('/books/validation/rules', 'API\BookController@validationRules')->name('books.validation-rules');

    Route::get('/profile', 'API\ProfileController@index')->name('profile.index');

});
