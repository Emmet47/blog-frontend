<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\AuthorMiddleware;
use Illuminate\Support\Facades\Route;
Route::middleware([ AuthorMiddleware::class])->group(function () {
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
});

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'showProfilePage'])->name('profile.show');
Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::get('/category/{id}', [BlogController::class, 'postsByCategory'])->name('category.show');
Route::post('/blog/{id}/comment', [CommentController::class, 'store'])->name('post.comments.store');
Route::post('/search', [BlogController::class, 'search'])->name('blog.search');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
