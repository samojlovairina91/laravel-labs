@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <a href="{{ route('articles.index') }}" style="color: #2980b9;">← К списку</a>

    <h1 style="margin-top: 15px;">{{ $article->title }}</h1>
    <p style="color: #777;">Опубликовано: {{ $article->published_at->format('d.m.Y') }}</p>

    @if ($article->full_image)
        <img src="{{ asset($article->full_image) }}"
             alt="{{ $article->title }}"
             style="max-width: 100%; height: auto; margin: 20px 0; border-radius: 8px;">
    @endif

    <p style="font-size: 16px; line-height: 1.6;">{{ $article->description }}</p>

    <div style="margin-top: 30px;">
        <a href="{{ route('articles.edit', $article->id) }}"
           style="background: #2980b9; color: #fff; padding: 8px 18px; text-decoration: none; border-radius: 5px;">
            Редактировать
        </a>
    </div>
        {{-- Блок комментариев --}}
    <hr style="margin: 40px 0;">
    <h2>Комментарии ({{ $article->comments->count() }})</h2>

    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 30px;">
        @forelse ($article->comments as $comment)
            <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid #2c3e50;">
                <div style="display: flex; justify-content: space-between;">
                    <strong style="color: #2c3e50;">{{ $comment->author }}</strong>
                    <small style="color: #999;">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                </div>
                <p style="margin-top: 10px; margin-bottom: 10px;">{{ $comment->content }}</p>
                
                {{-- Кнопки редактирования и удаления комментария --}}
                <div style="font-size: 13px;">
                    <a href="{{ route('comments.edit', $comment->id) }}" style="color: #2980b9; margin-right: 15px;">Редактировать</a>
                    
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить комментарий?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #c0392b; cursor: pointer; padding: 0; font-size: inherit; font-family: inherit;">Удалить</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="color: #777;">Комментариев пока нет. Будьте первым!</p>
        @endforelse
    </div>

    {{-- Форма добавления комментария --}}
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>Оставить комментарий</h3>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            
            <div style="margin-bottom: 10px;">
                <label>Ваше имя:</label>
                <input type="text" name="author" value="{{ old('author') }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                @error('author') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 10px;">
                <label>Комментарий:</label>
                <textarea name="content" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">{{ old('content') }}</textarea>
                @error('content') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            <button type="submit" style="background: #2c3e50; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Отправить</button>
        </form>
    </div>
@endsection