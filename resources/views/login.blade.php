@extends('layouts.app')

@section('title', 'Авторизация')

@section('content')

    <div class="auth-card">

        <h1>Вход в аккаунт</h1>

        <p class="subtitle">Войдите в свою учётную запись</p>

        <form id="login-form" class="auth-form">

            <label for="email">Электронная почта</label>
            <input type="email" id="email"
                   name="email" required>

            <label for="password">Пароль</label>
            <input type="password" id="password"
                   name="password" required>

            <button type="submit">Войти</button>

        </form>

        <p id="message" class="form-message"></p>

        <p>
            Нет аккаунта?
            <a href="/register">Зарегистрироваться</a>
        </p>

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endsection