<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LibraryController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\HomeController;


Route::get('/', [HomeController::class, 'index']);
Route::get('/library', [LibraryController::class, 'index']);
Route::get('/library/{id}', [LibraryController::class, 'projectsBelongsToSubject']);
Route::get('/document/{project}', [DocumentController::class, 'project']);
//Route::get('/document/{project}/{section}', [DocumentController::class, 'section']);
Route::get('/document/{project}/{slug}', [DocumentController::class, 'page']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

