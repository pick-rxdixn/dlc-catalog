@extends('layouts.app')

@section('title', 'Информация о дополнении')

@section('content')

    <a href="/" class="back-link">
        ← Вернуться в каталог
    </a>

    <article class="dlc-details" id="dlc-details"
             data-id="{{ $id }}"
             data-auth="{{ Auth::check() ? '1' : '0' }}">

        <p id="dlc-game" class="game-name"></p>

        <h1 id="dlc-title">Загрузка...</h1>

        <span id="dlc-category" class="category"></span>

        <p id="dlc-description"></p>

        @auth
            <button id="claim-button" disabled>
                Получить дополнение
            </button>
        @else
            <a href="/login" class="button">
                Войти для получения
            </a>
        @endauth

        <p id="message"></p>

    </article>

@endsection

@section('scripts')
    <script src="{{ asset('js/dlc.js') }}"></script>
@endsection