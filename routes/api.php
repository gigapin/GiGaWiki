<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {

    /*Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');
    Route::resource('subjects', SubjectController::class);
    Route::resource('projects', ProjectController::class);
    // Route::resource('sections', \App\Http\Controllers\Dashboard\SectionController::class);

    Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('sections/create/{id}', [SectionController::class, 'create'])->name('sections.create');
    Route::post('sections/store', [SectionController::class, 'store'])->name('sections.store');
    Route::get('projects/{project}/sections/{id}', [SectionController::class, 'show'])->name('sections.show');
    Route::get('sections/{id}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('sections/{id}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('sections/{id}', [SectionController::class, 'destroy'])->name('sections.destroy');
    Route::get('sections/{id}', [SectionController::class, 'delete'])->name('sections.delete');

    // Route::resource('pages', \App\Http\Controllers\Dashboard\LecturesController::class);
    Route::get('sections/{id}/pages/', [LecturesController::class, 'index'])->name('pages.index');
    Route::get('pages/create/{id}', [LecturesController::class, 'create'])->name('pages.create');
    Route::post('pages/store', [LecturesController::class, 'store'])->name('pages.store');
    Route::get('pages/{id}', [LecturesController::class, 'show'])->name('pages.show');
    Route::get('pages/{id}/edit', [LecturesController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{id}', [LecturesController::class, 'update'])->name('pages.update');
    Route::delete('pages/{id}', [LecturesController::class, 'destroy'])->name('pages.destroy');
    Route::get('pages/delete/{id}', [LecturesController::class, 'delete'])->name('pages.delete');

    Route::resource('accounts', \App\Http\Controllers\Dashboard\AccountsController::class);
    Route::resource('libraries', \App\Http\Controllers\Dashboard\LibrariesController::class);*/

    return $request->user();
});

