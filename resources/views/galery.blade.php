@extends('layouts.app')

@section('title', 'Галерея')

@section('content')
    <h1>Галерея</h1>
    <p>Полные изображения:</p>

    @if (count($articles) > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            @foreach ($articles as $article)
                <div style="background: #fff; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <img src="{{ asset($article['full_image']) }}"
                         alt="{{ $article['name'] }}"
                         style="width: 100%; height: auto; border-radius: 5px;">
                    <p style="margin-top: 8px;"><strong>{{ $article['name'] }}</strong></p>
                </div>
            @endforeach
        </div>
    @else
        <p>Изображений нет.</p>
    @endif
@endsection