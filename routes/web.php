<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

// --- ДОСТУПНО ВСЕМ (Главная, О нас, Контакты, Галерея, Вход/Регистрация) ---
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

// --- ЗАЩИЩЕНО (Только для авторизованных: Новости и Комментарии) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Новости (посредник auth:sanctum пускает только вошедших)
    Route::resource('articles', ArticleController::class);
    
    // Комментарии
    Route::resource('comments', CommentController::class);
});