@extends('layouts.app')

@section('title', 'Моя библиотека')

@section('content')

    <h1>Моя библиотека</h1>

    <p class="subtitle">
        Полученные вами дополнения к играм
    </p>

    <p id="library-count"></p>

    <div id="library" class="catalog-grid">
        <p>Загрузка библиотеки...</p>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/library.js') }}?v=2"></script>
@endsection