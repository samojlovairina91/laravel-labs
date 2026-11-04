<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Показывает страницу с формой регистрации
     */
    public function create()
    {
        return view('auth.signin');
    }

    /**
     * Принимает данные формы, валидирует и возвращает JSON
     */
    public function registration(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'name'     => 'required|string|min:2|max:50',
            'email'    => 'required|email|max:100',
            'password' => 'required|string|min:6|max:100',
        ]);

        // Собираем данные в массив (уже провалидированные)
        $data = [
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => $validated['password'], // в реальном проекте хэшируем!
            'created_at' => now()->toDateTimeString(),
        ];

        // Возвращаем JSON-ответ
        return response()->json([
            'status'  => 'success',
            'message' => 'Пользователь успешно зарегистрирован',
            'data'    => $data,
        ], 201);
    }
}