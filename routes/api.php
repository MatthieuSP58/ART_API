<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Select One 

Route::get('article/{article}', [ArticleController::class, 'show']);

//Select All
Route::get('article', [ArticleController::class, 'index']);

//Create One
Route::post('article', [ArticleController::class, 'store']);

//Update One
Route::put('article/{article}', [ArticleController::class, 'update']);

//Delete One
Route::delete('article/{article}', [ArticleController::class, 'destroy']);


