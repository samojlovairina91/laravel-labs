@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <h1>Контакты</h1>
    <p>Ниже — список наших контактных данных:</p>

    @if (count($contacts) > 0)
        <ul>
            @foreach ($contacts as $item)
                <li>
                    <strong>{{ $item['label'] }}:</strong> {{ $item['value'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>К сожалению, контакты пока не заполнены.</p>
    @endif
@endsection