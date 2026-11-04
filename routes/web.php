<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

// Главная
Route::get('/', [MainController::class, 'index'])->name('home');

// О нас
Route::get('/about', function () {
    return view('about');
})->name('about');

// Контакты
Route::get('/contacts', function () {
    $contacts = [
        ['label' => 'Телефон',  'value' => '+7 (999) 123-45-67'],
        ['label' => 'Email',    'value' => 'info@example.com'],
        ['label' => 'Адрес',    'value' => 'г. Москва, ул. Пушкина, д. 1'],
        ['label' => 'Telegram', 'value' => '@example'],
    ];

    return view('contacts', ['contacts' => $contacts]);
})->name('contacts');

// Галерея
Route::get('/galery', [MainController::class, 'galery'])->name('galery');

// Регистрация
Route::get('/signin',  [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('signin.post');

// CRUD новостей — 7 маршрутов одной строкой
Route::resource('articles', ArticleController::class);