<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Показ формы регистрации
    public function showRegister()
    {
        return view('auth.register');
    }

    // 2. Сохранение нового пользователя
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', 
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect на форму авторизации
        return redirect()->route('login')->with('success', 'Регистрация прошла успешно! Теперь войдите.');
    }

    // 3. Показ формы входа
    public function showLogin()
    {
        return view('auth.login');
    }

    // 4. Аутентификация (вход)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Генерируем токен Sanctum
            $token = $request->user()->createToken('auth_token')->plainTextToken;
            session(['api_token' => $token]); // сохраняем в сессию, если понадобится

            // Redirect на главную в обход auth
            return redirect()->route('home')->with('success', 'Вы вошли в систему!');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ])->onlyInput('email');
    }

    // 5. Выход
    public function logout(Request $request)
    {
        // Удаляем токен
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        // Выходим
        Auth::logout();

        // Аннулируем сессию и обновляем CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Вы вышли из системы.');
    }
}