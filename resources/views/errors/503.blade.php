@extends('layouts.app')

@section('title', 'Доступ запрещен')

@section('content')
    <div style="text-align: center; padding: 50px 20px;">
        <h1 style="font-size: 72px; color: #e74c3c; margin-bottom: 10px;">403</h1>
        <h2>У вас нет прав для этого действия</h2>
        <p style="color: #666; margin: 20px 0;">Извините, но ваша роль не позволяет выполнять это действие. Вы можете только читать новости и оставлять комментарии.</p>
        <a href="{{ route('home') }}" class="btn-register" style="text-decoration: none;">На главную</a>
    </div>
@endsection