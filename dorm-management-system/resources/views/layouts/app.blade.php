
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>DMS</title>
    <!-- Подключаем стили, FontAwesome -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<style>

</style>
<body>

<div class="top-nav">
    <div class="logo">
        {{-- Если есть логотип, раскомментируй:
        <img src="{{ asset('images/dms-logo.png') }}" alt="DMS Logo"> --}}
        DMS
    </div>
    <div class="nav-icons">
        {{-- Зелёный плюсик --}}
        <div class="icon-circle" style="background-color: #28a745;">
            <i class="fas fa-plus"></i>
        </div>
        {{-- Жёлтый колокольчик (уведомления) --}}
        <div class="icon-circle" style="background-color: #ffc107;">
            <i class="fas fa-bell"></i>
        </div>

        <!-- Обёртка для аватара и меню (открывается по hover) -->
        <div class="avatar-wrapper">
            <div class="avatar-circle">
                {{-- Первая буква имени --}}
                {{ mb_substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>

            <div class="avatar-dropdown">
                <!-- Кружок с буквой (увеличенный) -->
                <div class="avatar-circle avatar-circle-big">
                    {{ mb_substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>

                <!-- Имя пользователя -->
                <div class="avatar-name">
                    {{ Auth::user()->name }}
                </div>

                <!-- Профиль -->
                <a href="{{ route('student.personal') }}">Мой профиль</a>
                <!-- Выход (иконка + текст) -->
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i> <!-- Иконка выхода -->
                        Выход
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Сайдбар --}}
{{--<div class="sidebar">--}}
{{--    <a class="sidebar-item" href="{{ route('student.dashboard') }}">--}}
{{--        <i class="fas fa-home"></i>--}}
{{--        <span>Главная</span>--}}
{{--    </a>--}}
{{--    <a class="sidebar-item" href="{{ route('student.profile') }}">--}}
{{--        <i class="fas fa-user"></i>--}}
{{--        <span>Личная информация</span>--}}
{{--    </a>--}}
{{--    <!-- Остальные пункты -->--}}
{{--</div>--}}

{{-- Содержимое страницы --}}
@yield('content')

</body>
</html>
