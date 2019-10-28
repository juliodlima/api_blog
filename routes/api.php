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


// users
Route::prefix('user')->group(function () {
    Route::post("/cadastrar", "UserController@store");
});

// post
Route::prefix('post')->group(function () {
    Route::get("/", "PostController@view");
    Route::post("/cadastrar", "PostController@store");
});

// comment
Route::prefix('comment')->group(function () {
    Route::get("/", "CommentController@view");
    Route::post("/cadastrar", "CommentController@store");
});

// album
Route::prefix('album')->group(function () {
    Route::get("/", "AlbumController@view");
    Route::post("/cadastrar", "AlbumController@store");
});

// photo
Route::prefix('photo')->group(function () {
    Route::get("/", "PhotoController@view");
    Route::post("/cadastrar", "PhotoController@store");
});


