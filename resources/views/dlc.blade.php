@extends('layouts.app')

@section('title', 'Информация о дополнении')

@section('content')

    <a href="/" class="back-link">
        ← Вернуться в каталог
    </a>

    <article class="dlc-details" id="dlc-details"
             data-id="{{ $id }}"
             data-auth="{{ Auth::check() ? '1' : '0' }}">

        <img id="dlc-cover" class="dlc-cover" alt="" hidden>

        <div class="dlc-info">

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

        </div>

    </article>

    <section class="dlc-full-description">
        <h2>О дополнении</h2>
        <p id="dlc-full-description"></p>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('js/dlc.js') }}?v=3"></script>
@endsection