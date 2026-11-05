@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    

    @if (count($articles) > 0)
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: #fff;">
            <thead style="background: #2c3e50; color: #fff;">
                <tr>
                    <th>Дата</th>
                    <th>Превью</th>
                    <th>Заголовок</th>
                    <th>Краткое описание</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article['date'] }}</td>
                        <td>
                            <a href="{{ route('galery') }}">
                                <img src="{{ asset($article['preview_image']) }}"
                                     alt="{{ $article['name'] }}"
                                     style="width: 120px; height: auto; display: block;">
                            </a>
                        </td>
                        <td><strong>{{ $article['name'] }}</strong></td>
                        <td>{{ $article['shortDesc'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Новостей пока нет.</p>
    @endif
@endsection