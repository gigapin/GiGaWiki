<?php

use App\Http\Controllers\Dashboard\AccountMailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\PageController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\CommentController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\FavoriteController;
use App\Http\Controllers\Dashboard\RevisionController;
use App\Http\Controllers\Dashboard\PDFController;
use App\Http\Controllers\Dashboard\ImageController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Auth\UserInvitedRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\DocumentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvsluger within a group which
| contains the "web" mslugdleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/library', [LibraryController::class, 'index'])->name('library');
Route::get('/library/{slug}', [LibraryController::class, 'show'])->name('library.show');
Route::get('/document/{slug}', [DocumentController::class, 'index'])->name('document');
Route::get('/document/{project}/{section}/{slug}', [DocumentController::class, 'show'])->name('document.show');





require __DIR__.'/auth.php';

Route::get('/register/{id}/{role_id}', [UserInvitedRegisterController::class, 'create'])
                ->middleware('guest')
                ->name('register');

Route::post('/register/{id}/{role_id}', [UserInvitedRegisterController::class, 'store'])
                ->middleware('guest');


/** ROUTES AUTH MIDDLEWARE GROUP */
Route::middleware(['auth'])->prefix('dashboard')->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('subjects/{slug}', [SubjectController::class, 'show'])->name('subjects.show');
    Route::get('subjects/{slug}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::patch('subjects/{slug}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::get('subjects/{slug}/destroy', [SubjectController::class, 'delete'])->name('subjects.destroy');
    Route::delete('subjects/{slug}', [SubjectController::class, 'destroy'])->name('subjects.delete');

    Route::resource('projects', ProjectController::class);
    Route::get('projects/{slug}/destroy', [ProjectController::class, 'delete'])->name('projects.destroy');
    Route::delete('projects/{slug}', [ProjectController::class, 'destroy'])->name('projects.delete');

    Route::get('projects/{slug}/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('sections/store', [SectionController::class, 'store'])->name('sections.store');
    Route::get('projects/{project}/sections/{slug}', [SectionController::class, 'show'])->name('sections.show');
    Route::get('sections/{slug}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('sections/{slug}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('sections/{slug}', [SectionController::class, 'destroy'])->name('sections.destroy');
    Route::get('sections/{slug}', [SectionController::class, 'delete'])->name('sections.delete');

    Route::get('projects/{project}/sections/{section}/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('pages/{slug}', [PageController::class, 'show'])->name('pages.show');
    Route::get('pages/{slug}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{slug}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('pages/{slug}', [PageController::class, 'destroy'])->name('pages.delete');
    Route::get('pages/{slug}/destroy', [PageController::class, 'delete'])->name('pages.destroy');

    Route::post('{model}/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('{model}/{slug}/comments/{id}', [CommentController::class, 'reply'])->name('comments.reply');
    Route::put('{model}/{slug}/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('{model}/{slug}/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('tags/{name}', [TagController::class, 'show'])->name('tags.show');
    Route::delete('tags/{id}', [TagController::class, 'destroy'])->name('tags.delete');

    Route::get('{project:slug}/page/{page:id}/revision', [RevisionController::class, 'index'])->name('revisions.index');
    Route::get('{project}/{page}/revision/restore/{id}', [RevisionController::class, 'restore'])->name('revisions.restore');
    Route::get('{project}/{page}/revision/preview/{id}', [RevisionController::class, 'preview'])->name('revisions.preview');
    Route::delete('{project}/{page}/revision/delete/{id}', [RevisionController::class, 'delete'])->name('revisions.delete');

    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{id}', [FavoriteController::class, 'delete'])->name('favorites.delete');

    Route::get('{slug}/export/pdf', [PDFController::class, 'generatePdf'])->name('export.pdf');

    Route::post('images', [ImageController::class, 'store'])->name('images.store');
    Route::get('images', [ImageController::class, 'index'])->name('images.index');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
    Route::get('settings/security', [SettingController::class, 'security'])->name('settings.security');
    Route::patch('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/maintenance', [SettingController::class, 'maintenance'])->name('settings.maintenance');
    Route::get('settings/users', [SettingController::class, 'users'])->name('settings.users');
    Route::get('settings/roles', [SettingController::class, 'roles'])->name('settings.roles');
    Route::get('settings/recycle-bin', [SettingController::class, 'recycle'])->name('settings.recycle-bin');
    Route::delete('settings/recycle-bin/force-delete/{id}', [SettingController::class, 'forceDelete'])->name('settings.force-delete');
    Route::get('settings/recycle-bin/restore/{id}', [SettingController::class, 'restore'])->name('settings.restore');
    Route::delete('settings/recycle-bin/empty', [SettingController::class, 'emptyRecycleBin'])->name('settings.empty-bin');
    Route::delete('settings/recycle-bin/cleanup-images', [SettingController::class, 'cleanupImages'])->name('settings.cleanup-images');
    Route::get('settings/recycle-bin/delete-images', [SettingController::class, 'deleteImages'])->name('settings.delete-images');
    Route::delete('settings/recycle-bin/force-cleanup-images', [SettingController::class, 'forceCleanupImages'])->name('settings.force.cleanup.images');
    Route::get('settings/users', [SettingController::class, 'users'])->name('settings.users');
    Route::get('settings/roles', [SettingController::class, 'roles'])->name('settings.roles');
    Route::get('settings/users/{slug}/edit', [SettingController::class, 'editUser'])->name('settings.users.edit');
    Route::patch('settings/users/{slug}', [SettingController::class, 'updateUser'])->name('settings.users.update');

    Route::resource('users', UserController::class);
    Route::get('users/{slug}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{slug}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{slug}', [UserController::class, 'update'])->name('users.update');
    Route::get('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    

    Route::get('send', [AccountMailController::class, 'sendMail']);
    

});


