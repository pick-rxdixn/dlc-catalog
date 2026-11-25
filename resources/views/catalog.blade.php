@extends('layouts.app')

@section('title', 'Каталог дополнений')

@section('content')

    <h1>Каталог дополнений</h1>

    <p class="subtitle">
        Найдите дополнения к любимым играм
    </p>

    <div class="filters">
        <input type="search" id="search"
               placeholder="Поиск дополнений...">

        <select id="game-filter">
            <option value="">Все игры</option>
        </select>

        <select id="category-filter">
            <option value="">Все категории</option>
        </select>

        <button id="reset-filters">Сбросить</button>
    </div>

    <div id="catalog" class="catalog-grid">
        <p>Загрузка дополнений...</p>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/catalog.js') }}"></script>
@endsection