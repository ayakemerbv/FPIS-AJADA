@extends('layouts.auth')

@section('title', 'Вход')

@section('content')
    <style>
        /* Сбрасываем отступы */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Фон с картинкой */
        body {
            /* Задаём фоновое изображение */
            background: url("{{ asset('images/login-bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }

        /* Контейнер для выравнивания по центру */
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* занимаем всю высоту экрана */
        }

        /* Белая карточка */
        .login-card {
            background: rgba(255, 255, 255, 0.9); /* полупрозрачный белый */
            border-radius: 8px;
            padding: 2rem;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        /* Логотип (если есть изображение) */
        .login-card .logo {
            width: 80px;
            margin-bottom: 1rem;
        }

        /* Заголовок */
        .login-card h2 {
            margin-bottom: 1.5rem;
            color: #333;
            font-weight: 600;
        }

        /* Поля ввода */
        .form-control {
            border-radius: 30px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            width: 100%;
        }

        /* Кнопка */
        .btn-primary {
            background-color: #7e57c2; /* Фиолетовый */
            border: none;
            border-radius: 30px;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            cursor: pointer;
            margin-top: 1rem;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #673ab7; /* более тёмный фиолетовый */
        }

        /* Ссылка «Забыли пароль?» */
        .forgot-password {
            display: block;
            margin-top: 0.5rem;
            text-decoration: none;
            color: #666;
            font-size: 0.9rem;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Сообщение об ошибке */
        .alert.alert-danger {
            margin-bottom: 1rem;
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            color: #842029;
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            {{-- Логотип DMS (если есть отдельная картинка, например dms-logo.png) --}}
            {{-- <img src="{{ asset('images/dms-logo.png') }}" alt="DMS Logo" class="logo"> --}}

            {{-- Или, если логотип — это текст/иконка, просто оставляем заголовок --}}
            <h2>Войти в аккаунт</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    placeholder="Введите почту"
                    value="{{ old('email') }}"
                    required
                >
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Введите пароль"
                    required
                >
                <a href="#" class="forgot-password">Забыли пароль?</a>

                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
@endsection
