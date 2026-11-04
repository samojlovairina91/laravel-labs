@extends('layouts.app')

@section('title', 'Редактировать новость')

@section('content')
    <h1>Редактировать новость</h1>

    <form action="{{ route('articles.update', $article->id) }}" method="POST" style="max-width: 700px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Заголовок:</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            @error('title') <small style="color: #c0392b;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Краткое описание:</label>
            <textarea name="short_description" rows="3"
                      style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">{{ old('short_description', $article->short_description) }}</textarea>
            @error('short_description') <small style="color: #c0392b;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Полное описание:</label>
            <textarea name="description" rows="8"
                      style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">{{ old('description', $article->description) }}</textarea>
            @error('description') <small style="color: #c0392b;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Имя превью-картинки:</label>
            <input type="text" name="preview_image" value="{{ old('preview_image', $article->preview_image) }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            @error('preview_image') <small style="color: #c0392b;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Имя полной картинки:</label>
            <input type="text" name="full_image" value="{{ old('full_image', $article->full_image) }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            @error('full_image') <small style="color: #c0392b;">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Дата публикации:</label>
            <input type="date" name="published_at"
                   value="{{ old('published_at', $article->published_at->format('Y-m-d')) }}"
                   style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            @error('published_at') <small style="color: #c0392b;">{{ $message }}</small> @enderror
        </div>

        <button type="submit"
                style="background: #2980b9; color: #fff; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer;">
            Обновить
        </button>
        <a href="{{ route('articles.index') }}" style="margin-left: 15px;">Отмена</a>
    </form>
@endsection