@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <h1>Регистрация</h1>

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" style="max-width: 500px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Имя:</label>
            <input type="text" name="name" value="{{ old('name') }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Пароль:</label>
            <input type="password" name="password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Повторите пароль:</label>
            <input type="password" name="password_confirmation" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <button type="submit" style="background: #27ae60; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Зарегистрироваться</button>
    </form>
@endsection