@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <h1>Вход в систему</h1>

    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" style="max-width: 500px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Пароль:</label>
            <input type="password" name="password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <button type="submit" style="background: #2c3e50; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Войти</button>
    </form>
@endsection