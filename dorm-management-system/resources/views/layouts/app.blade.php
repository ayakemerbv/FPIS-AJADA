
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
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<style>
    /* ========== СБРОС И ОБЩИЕ СТИЛИ ========== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #F5F5F5;
    }

    /* ========== КРУГЛЫЕ ИКОНОКИ ========== */
    .icon-circle,
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
    }
    .icon-circle i,
    .avatar-circle i {
        font-size: 16px;
    }
    .avatar-circle {
        background-color: #6f42c1; /* Фиолетовый */
        font-weight: bold;
    }

    /* ========== ВЕРХНЯЯ ПАНЕЛЬ ========== */
    .top-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 60px;
        padding: 0 20px;
        background-color: #FFF;
        border-bottom: 1px solid #DDD;
    }
    .top-nav .logo {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 24px;
        font-weight: bold;
        color: #4A4A4A;
    }

    .top-nav .nav-icons {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    /* ========== АВАТАР + ВСПЛЫВАЮЩЕЕ МЕНЮ ========== */
    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }
    .avatar-dropdown {
        display: none;
        position: absolute;
        top: 110%;
        right: 0;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        width: 160px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        z-index: 999;
        text-align: center;
    }
    .avatar-wrapper:hover .avatar-dropdown {
        display: block;
    }

    .avatar-dropdown a {
        display: block;
        text-decoration: none;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    .avatar-dropdown a:hover {
        text-decoration: underline;
    }
    /* ========== СТИЛИ ДЛЯ НОВОСТЕЙ ========== */
    .news-item {
        background-color: #B0A5D7; /* Фиолетовый */
        padding: 15px;
        color: #fff;
        max-width: 1500px;
        height: 240px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .news-item h3 {
        margin-bottom: 10px;
        color: #fff;
    }
    .news-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .news-item small {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    .avatar-circle-big {
        width: 45px;
        height: 45px;
        font-size: 20px;
        margin-left: 50px;
        /*display: flex;*/
        /*justify-content: center;*/
        /*align-items: center;*/
        /*flex-direction: column;*/
        margin-bottom: 5px;
    }
    .logo-link {
        display: flex;
        align-items: center; /* Выравнивает по вертикали */
        text-decoration: none; /* Убирает подчеркивание у ссылки */
        color: inherit; /* Наследует цвет текста */
    }

    .logo-img {
        height: 40px; /* Или любой другой размер */
        margin-right: 10px; /* Отступ между логотипом и текстом */
    }

    .logo-text {
        font-size: 20px; /* Размер текста */
        font-weight: bold; /* Жирный шрифт */
    }


</style>
<body>
<div class="top-nav">
    <div class="logo">
        <a href="{{ route('student.dashboard') }}" class="logo-link">
            <img src="{{ asset('storage/icon/dark icon.png') }}" alt="DMS Logo" class="logo-img">
            <span class="logo-text">DMS</span>
        </a>
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
                @if(Auth::user()->role === 'student')
                    <a href="{{ route('student.personal') }}">Мой профиль</a>
                @endif

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
{{-- Содержимое страницы --}}
@yield('content')

</body>
</html>
