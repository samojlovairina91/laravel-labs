@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <h1>Регистрация</h1>

    {{-- Вывод ошибок валидации (если форма отправлена как HTML) --}}
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 15px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('signin.post') }}" method="POST" style="max-width: 500px;">
        @csrf

        <div style="margin-bottom: 15px;">
            <label for="name" style="display: block; margin-bottom: 5px;">Имя:</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name') }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email') }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block; margin-bottom: 5px;">Пароль:</label>
            <input type="password" name="password" id="password"
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <button type="submit"
                style="background: #2c3e50; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Зарегистрироваться
        </button>
    </form>
@endsection