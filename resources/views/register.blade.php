@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')

    <div class="auth-card">

        <h1>Регистрация</h1>

        <p class="subtitle">Создайте свой аккаунт</p>

        <form id="register-form" class="auth-form">

            <label for="name">Имя</label>
            <input type="text" id="name"
                   name="name" required maxlength="255">

            <label for="email">Электронная почта</label>
            <input type="email" id="email"
                   name="email" required maxlength="255">

            <label for="password">Пароль</label>
            <input type="password" id="password"
                   name="password" required minlength="8">

            <label for="password_confirmation">
                Подтверждение пароля
            </label>
            <input type="password" id="password_confirmation"
                   name="password_confirmation" required>

            <button type="submit">
                Зарегистрироваться
            </button>

        </form>

        <p id="message" class="form-message"></p>

        <p>
            Уже есть аккаунт?
            <a href="/login">Войти</a>
        </p>

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endsection