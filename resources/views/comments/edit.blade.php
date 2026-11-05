@extends('layouts.app')

@section('title', 'Редактировать комментарий')

@section('content')
    <h1>Редактировать комментарий</h1>
    <p>К статье: <a href="{{ route('articles.show', $comment->article_id) }}">{{ $comment->article->title }}</a></p>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST" style="max-width: 600px; margin-top: 20px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Ваше имя:</label>
            <input type="text" name="author" value="{{ old('author', $comment->author) }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            @error('author') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Комментарий:</label>
            <textarea name="content" rows="5" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">{{ old('content', $comment->content) }}</textarea>
            @error('content') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <button type="submit" style="background: #2980b9; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Сохранить</button>
        <a href="{{ route('articles.show', $comment->article_id) }}" style="margin-left: 15px;">Отмена</a>
    </form>
@endsection