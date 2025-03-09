@extends('layouts.app')

@section('content')
    <style>
        /* СБРОС */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }
        /* ОБЩИЕ СТИЛИ ДЛЯ КРУГЛЫХ ИКОНОК */
        .icon-circle, .avatar-circle {
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
        .icon-circle i {
            font-size: 16px;
        }
        .avatar-circle {
            background-color: #6f42c1; /* Фиолетовый */
            font-weight: bold;
        }

        /* ВЕРХНЯЯ ПАНЕЛЬ */
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
        /* Если есть логотип-изображение, раскомментируй:
        .top-nav .logo img {
            height: 40px;
        } */
        .top-nav .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* ОБЁРТКА ДЛЯ АВАТАРА И МЕНЮ */
        .avatar-wrapper {
            position: relative;
            display: inline-block;
        }
        /* Меню скрыто по умолчанию */
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
        /* При наведении на .avatar-wrapper показываем меню */
        .avatar-wrapper:hover .avatar-dropdown {
            display: block;
        }

        .avatar-name {
            font-weight: bold;
            color: #4A4A4A;
            margin-bottom: 8px;
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

        /* ЛЕВАЯ ПАНЕЛЬ */
        .sidebar {
            position: fixed;
            top: 60px; /* высота шапки */
            left: 0;
            width: 200px;
            height: calc(100vh - 60px);
            background-color: #FFF;
            border-right: 1px solid #DDD;
            padding-top: 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
        }
        .sidebar-item:hover {
            background-color: #EFEFEF;
            cursor: pointer;
        }
        .sidebar-item i {
            font-size: 18px;
            color: #4A4A4A;
        }

        /* ОСНОВНОЙ КОНТЕНТ */
        .main-content {
            margin-left: 200px; /* отступ под ширину сайдбара */
            padding: 20px;
            padding-top: 80px;  /* чтобы контент не лез под шапку */
        }
        .main-content h2 {
            margin-bottom: 20px;
            color: #4A4A4A;
        }

        /* СТИЛИ ДЛЯ НОВОСТЕЙ */
        .news-item {
            background-color: #B0A5D7; /* Фиолетовый */
            padding: 35px;
            color: #fff;
            max-width: 1200px; /* или 200px, на твой вкус */
            height: 250px;     /* сохраняем пропорции */
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .news-item h3 {
            margin-bottom: 10px;
            color: #fff;
        }
        .news-item img {
            width: 100px;       /* Force a wide width */
            height: 100px;      /* Make it half as tall => "landscape" shape */
            object-fit: cover;  /* Crop edges if the ratio doesn't match exactly */
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .news-item small {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        /* Увеличенный кружок с буквой внутри меню (опционально) */
        .avatar-circle-big {
            width: 50px;
            height: 50px;
            font-size: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 8px;
        }

        /* Кнопка выхода (с иконкой) */
        .logout-form button {
            background: none;
            border: none;
            color: #333;
            font-size: 0.9rem;
            cursor: pointer;
            /*display: flex;*/
            /*justify-content: center;!* иконка + текст в одну строку *!*/
            /*align-items: center;*/
            gap: 6px;            /* отступ между иконкой и текстом */
        }
        .logout-form button:hover {
            text-decoration: underline;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }

        /* Основной контейнер */
        .main-content {
            margin-left: 200px; /* Если у тебя сайдбар 200px */
            padding: 20px;
            padding-top: 80px; /* чтобы не залезать под шапку */
            background-color: #F5F5F5;
            min-height: calc(100vh - 60px);
        }

        /* Заголовок */
        .main-content h2 {
            margin-bottom: 20px;
            color: #4A4A4A;
            font-size: 1.2rem;
        }

        /* Карточка «Личные данные» */
        .personal-card {
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 8px;
            padding: 20px;
        }

        /* Контейнер с фото и основной инфой */
        .personal-content {
            display: flex;
            gap: 20px;
        }

        /* Левая часть — фото */
        .personal-photo {
            width: 180px;
            height: 180px;
            border-radius: 8px;
            overflow: hidden;
        }
        .personal-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* чтобы фото заполняло блок */
        }

        /* Правая часть — текст и форма */
        .personal-info {
            flex: 1; /* чтобы занимала оставшееся пространство */
        }
        .personal-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .personal-status {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 8px;
        }
        .personal-location {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 16px;
        }

        /* Сетка для ID, телефона, email, пароля */
        .personal-form {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 столбца */
            gap: 15px;
        }
        .personal-form label {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 4px;
            display: block;
        }
        .personal-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #CCC;
            border-radius: 4px;
        }

        /* Кнопка */
        .personal-actions {
            margin-top: 20px;
        }
        .btn-change {
            background-color: #7e57c2;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-change:hover {
            background-color: #6f42c1;
        }
        #news-section,
        #personal-section {
            display: none; /* скрыты */
        }

        /* Общие стили для .main-content */
        .main-content {
            margin-left: 200px;
            padding: 20px;
            padding-top: 80px;
        }
    </style>


{{--     ЛЕВАЯ ПАНЕЛЬ--}}
    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>Главная</span>
        </div>
        <a class="sidebar-item" onclick="showPersonal()">
            <i class="fas fa-store"></i>
            <span>Личная информация</span>
        </a>

        <div class="sidebar-item">
            <i class="fas fa-store"></i>
            <span>Проживание</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-store"></i>
            <span>Документы</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-store"></i>
            <span>Финансовый кабинет</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-store"></i>
            <span>Запросы на ремонт</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-store"></i>
            <span>Запись на занятия физкультурой</span>
        </div>

    </div>

    {{-- Блок с новостями --}}
    <div class="main-content" id="news-section">
        <h2>Новости</h2>
        @isset($newsList)
            @forelse($newsList as $news)
                <div class="news-item">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="News Image">
                    @endif
                    <h3>{{ $news->title }}</h3>
                    <p>{{ $news->content }}</p>
                    <small>{{ $news->created_at->format('d.m.Y H:i') }}</small>
                </div>
            @empty
                <p>Нет новостей</p>
            @endforelse
        @endisset
    </div>

    {{-- Блок с личной информацией --}}
    <div class="main-content" id="personal-section">
        <h2>Личные данные</h2>
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="personal-card">
            <div class="personal-content">
                <div class="personal-photo">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User Photo">
                    @else
                        <img src="https://via.placeholder.com/180x180?text=No+Photo" alt="User Photo">
                    @endif
                </div>
                <div class="personal-info">
                    <div class="personal-name">{{ Auth::user()->name }}</div>
                    <div class="personal-status">Статус: Проживающий</div>
                    <div class="personal-location">Корпус 1, блок 2, комната 145</div>

                    <form class="personal-form"
                          action="{{ route('student.profile.update') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label>ID</label>
                            <input type="text" value="{{ Auth::user()->user_id }}" disabled>
                        </div>
                        <div>
                            <label>Номер телефона</label>
                            <input type="text" name="phone"
                                   value="{{ old('phone', Auth::user()->phone ?? '') }}">
                        </div>
                        <div>
                            <label>E-Mail</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div>
                            <label>Пароль</label>
                            <input type="password" value="{{ Auth::user()->password }}" disabled>
                        </div>
                        <div>
                            <label>Фото</label>
                            <input type="file" name="photo">
                        </div>
                        <div class="personal-actions" style="grid-column: 1 / span 2; text-align: right;">
                            <button type="submit" class="btn-change">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // При загрузке страницы показываем "Главная" или "Личная информация"?
        // Пусть по умолчанию показываем главную (новости).
        document.addEventListener('DOMContentLoaded', function() {
            showNews();
        });

        function showNews() {
            // Показываем блок новостей, скрываем блок личной инфы
            document.getElementById('news-section').style.display = 'block';
            document.getElementById('personal-section').style.display = 'none';
        }

        function showPersonal() {
            // Показываем блок личной инфы, скрываем блок новостей
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('personal-section').style.display = 'block';
        }
    </script>
@endsection
