@extends('layouts.app')

@section('title', 'Новости')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Новости (из базы данных)</h1>
        
        {{-- Кнопка добавления видна только модераторам --}}
        @if(auth()->check() && auth()->user()->isModerator())
            <a href="{{ route('articles.create') }}"
               style="background: #27ae60; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                + Добавить новость
            </a>
        @endif
    </div>

    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if ($articles->count() > 0)
        <table border="1" cellpadding="10" cellspacing="0"
               style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <thead style="background: #2c3e50; color: #fff;">
                <tr>
                    <th>Дата</th>
                    <th>Превью</th>
                    <th>Заголовок</th>
                    <th>Краткое описание</th>
                    
                    {{-- Показываем колонку Действия ТОЛЬКО модераторам --}}
                    @if(auth()->check() && auth()->user()->isModerator())
                        <th>Действия</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td style="white-space: nowrap;">{{ $article->published_at->format('d.m.Y') }}</td>
                        <td>
                            @if ($article->preview_image)
                                <img src="{{ asset($article->preview_image) }}"
                                     alt="{{ $article->title }}"
                                     style="width: 100px; height: auto; border-radius: 4px;">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('articles.show', $article->id) }}"
                               style="color: #2c3e50; text-decoration: none; font-size: 16px;">
                                <strong>{{ $article->title }}</strong>
                            </a>
                        </td>
                        <td style="font-size: 14px; color: #555;">{{ Str::limit($article->short_description, 80) }}</td>
                        
                        {{-- Показываем кнопки ТОЛЬКО модераторам --}}
                        @if(auth()->check() && auth()->user()->isModerator())
                            <td style="white-space: nowrap;">
                                <a href="{{ route('articles.edit', $article->id) }}"
                                   style="color: #2980b9; text-decoration: none; font-weight: bold; margin-right: 15px;">
                                    ✎ Ред.
                                </a>

                                <form action="{{ route('articles.destroy', $article->id) }}"
                                      method="POST"
                                      style="display: inline;"
                                      onsubmit="return confirm('Точно удалить новость?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background: none; border: none; color: #c0392b; cursor: pointer; padding: 0; font-weight: bold; font-family: inherit; font-size: inherit;">
                                        🗑 Удалить
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Красивая пагинация --}}
        <div style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 30px;">
            @if ($articles->onFirstPage())
                <span style="padding: 10px 20px; background: #e0e0e0; color: #999; border-radius: 5px; cursor: not-allowed; user-select: none;">
                    &laquo; Назад
                </span>
            @else
                <a href="{{ $articles->previousPageUrl() }}" style="padding: 10px 20px; background: #2c3e50; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.2s;">
                    &laquo; Назад
                </a>
            @endif

            <span style="font-weight: bold; color: #555; font-size: 15px;">
                Страница {{ $articles->currentPage() }} из {{ $articles->lastPage() }}
            </span>

            @if ($articles->hasMorePages())
                <a href="{{ $articles->nextPageUrl() }}" style="padding: 10px 20px; background: #2c3e50; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.2s;">
                    Вперёд &raquo;
                </a>
            @else
                <span style="padding: 10px 20px; background: #e0e0e0; color: #999; border-radius: 5px; cursor: not-allowed; user-select: none;">
                    Вперёд &raquo;
                </span>
            @endif
        </div>
    @else
        <div style="background: #fff; padding: 20px; text-align: center; border-radius: 8px;">
            <p style="font-size: 18px; color: #666;">Новостей пока нет.</p>
            @if(auth()->check() && auth()->user()->isModerator())
                <a href="{{ route('articles.create') }}" style="color: #27ae60; font-weight: bold;">Создать первую новость</a>
            @endif
        </div>
    @endif
@endsection