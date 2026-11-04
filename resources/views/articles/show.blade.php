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
@endsection