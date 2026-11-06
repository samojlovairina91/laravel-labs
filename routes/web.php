<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

// --- ДОСТУПНО ВСЕМ ---
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contacts', function () {
    $contacts = [
        ['label' => 'Телефон',  'value' => '+7 (999) 123-45-67'],
        ['label' => 'Email',    'value' => 'info@example.com'],
        ['label' => 'Адрес',    'value' => 'г. Москва, ул. Пушкина, д. 1'],
    ];
    return view('contacts', ['contacts' => $contacts]);
})->name('contacts');
Route::get('/galery', [MainController::class, 'galery'])->name('galery');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// --- ЗАЩИЩЕНО (Только для авторизованных) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // 1. Сначала ставим кастомные маршруты модерации!
    Route::get('/comments/moderation', [CommentController::class, 'moderation'])->name('comments.moderation');
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');

    // 2. А теперь ресурсные маршруты
    Route::resource('articles', ArticleController::class);
    Route::resource('comments', CommentController::class);
});