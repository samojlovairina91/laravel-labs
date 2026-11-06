@extends('layouts.app')

@section('title', 'Модерация комментариев')

@section('content')
    <h1>Модерация комментариев</h1>

    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($comments->count() > 0)
        @foreach ($comments as $comment)
            <div style="background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 4px solid #f39c12;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <strong>{{ $comment->author }}</strong>
                    <small style="color: #999;">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                </div>
                
                <p style="margin-bottom: 10px;">{{ $comment->content }}</p>
                <p style="font-size: 13px; color: #666; margin-bottom: 15px;">
                    К статье: <a href="{{ route('articles.show', $comment->article_id) }}" style="color: #2980b9;">{{ $comment->article->title }}</a>
                </p>

                <div style="display: flex; gap: 10px;">
                    <form action="{{ route('comments.approve', $comment->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: #27ae60; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Принять</button>
                    </form>
                    <form action="{{ route('comments.reject', $comment->id) }}" method="POST" onsubmit="return confirm('Отклонить и удалить?');">
                        @csrf
                        <button type="submit" style="background: #c0392b; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Отклонить</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p>Нет комментариев, ожидающих модерации.</p>
    @endif
@endsection