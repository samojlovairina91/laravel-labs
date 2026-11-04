@extends('layouts.app')

@section('title', 'Новости')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Новости (из базы данных)</h1>
        <a href="{{ route('articles.create') }}"
           style="background: #27ae60; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            + Добавить новость
        </a>
    </div>

    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($articles->count() > 0)
        <table border="1" cellpadding="10" cellspacing="0"
               style="width: 100%; border-collapse: collapse; background: #fff;">
            <thead style="background: #2c3e50; color: #fff;">
                <tr>
                    <th>Дата</th>
                    <th>Превью</th>
                    <th>Заголовок</th>
                    <th>Краткое описание</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article->published_at->format('d.m.Y') }}</td>
                        <td>
                            @if ($article->preview_image)
                                <img src="{{ asset($article->preview_image) }}"
                                     alt="{{ $article->title }}"
                                     style="width: 100px; height: auto;">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('articles.show', $article->id) }}"
                               style="color: #2c3e50; text-decoration: none;">
                                <strong>{{ $article->title }}</strong>
                            </a>
                        </td>
                        <td>{{ Str::limit($article->short_description, 80) }}</td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('articles.edit', $article->id) }}"
                               style="color: #2980b9; margin-right: 10px;">✎ Ред.</a>

                            <form action="{{ route('articles.destroy', $article->id) }}"
                                  method="POST"
                                  style="display: inline;"
                                  onsubmit="return confirm('Удалить новость?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background: none; border: none; color: #c0392b; cursor: pointer; padding: 0;">
                                    🗑 Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Пагинация --}}
        <div style="margin-top: 20px;">
            {{ $articles->links() }}
        </div>
    @else
        <p>Новостей пока нет. <a href="{{ route('articles.create') }}">Создать первую</a></p>
    @endif
@endsection