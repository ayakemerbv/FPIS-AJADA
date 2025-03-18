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

        /* Кнопка выхода (с иконкой) */
        .logout-form button {
            background: none;
            border: none;
            color: #333;
            font-size: 0.9rem;
            cursor: pointer;
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
            font-size: 1.5rem;
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
        /* Карточки для блока "Проживание" */
        .housing-card {
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px; /* отступ между карточками */
        }
        .housing-card h3 {
            margin-bottom: 10px;
            font-size: 1.2rem;
            color: #333;
        }
        .housing-card p {
            color: #666;
            margin-bottom: 10px;
        }
        .btn-finance {
            background-color: #7e57c2;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .btn-finance:hover {
            background-color: #6f42c1;
        }

        /* Скрываем некоторые секции по умолчанию */
        #personal-section,
        #housing-section {
            display: none;
        }
        /* Проживание (housing-section) */
        .housing-card {
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .housing-card h3 {
            margin-bottom: 10px;
            font-size: 1.2rem;
            color: #333;
        }
        .housing-card p {
            color: #666;
            margin-bottom: 10px;
        }
        .btn-finance {
            background-color: #7e57c2;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .btn-finance:hover {
            background-color: #6f42c1;
        }

        /* Модальное окно (смена пароля / смена комнаты) */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .modal-content {
            background: #fff;
            width: 400px;
            padding: 20px;
            border-radius: 8px;
            position: relative;
        }
        .modal-content h2 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        .modal-content .form-group {
            margin-bottom: 12px;
        }
        .modal-content label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .modal-content input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
        }
        .close-button:hover {
            color: #666;
        }

    </style>


{{--     ЛЕВАЯ ПАНЕЛЬ--}}
    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>Главная</span>
        </div>
        <a class="sidebar-item" onclick="showPersonal()">
            <i class="fas fa-user"></i>
            <span>Личная информация</span>
        </a>

        <div class="sidebar-item" onclick="showHousing()">
            <i class="fas fa-building"></i>
            <span>Проживание</span>
        </div>
        <div class="sidebar-item">
            <i class="fa-solid fa-clipboard">‌</i>
            <span>Документы</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-coins"></i>
            <span>Финансовый кабинет</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-wrench"></i>
            <span>Запросы на ремонт</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-trophy"></i>
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

    <div class="main-content" id="personal-section" style="display: none;">
        <h2>Личные данные</h2>
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

                    <!-- Пример локации -->
                    <div class="personal-location">
                        @if(Auth::user()->acceptedBooking)
                            Корпус: {{ Auth::user()->acceptedBooking->building->name }}<br>
                            Адрес: {{ Auth::user()->acceptedBooking->building->address }}<br>
                            Этаж: {{ Auth::user()->acceptedBooking->room->floor }}<br>
                            Комната: {{ Auth::user()->acceptedBooking->room->room_number }}
                        @else
                            <p>Пока не заселен</p>
                        @endif
                    </div>

                    <!-- Форма для изменения телефона и фото -->
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
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                        </div>
                        <div>
                            <label>E-Mail</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div>
                            <label>Пароль</label>
                            <!-- Вместо реального пароля показываем звездочки -->
                            <div style="display: flex; gap: 10px;">
                                <input type="password" value="********" disabled>
                                <!-- Кнопка, открывающая модальное окно -->
                                <button type="button" class="btn-change" onclick="openPasswordModal()">
                                    Изменить
                                </button>
                            </div>
                        </div>
                        <div>
                            <label>Фото</label>
                            <input type="file" name="photo">
                        </div>
                        <div class="personal-actions">
                            <button type="submit" class="btn-change">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- МОДАЛЬНОЕ ОКНО ДЛЯ СМЕНЫ ПАРОЛЯ -->
    <div class="modal-overlay" id="passwordModal">
        <div class="modal-content">
            <button class="close-button" onclick="closePasswordModal()">&times;</button>
            <h2>Изменить пароль</h2>
            <!-- Если хотите выводить сообщения об успехе/ошибке -->
            @if(session('password_success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px;">
                    {{ session('password_success') }}
                </div>
            @endif
            <!-- Форма для смены пароля -->
            <form action="{{ route('student.profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="current_password">Текущий пароль</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Новый пароль</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">Повторите новый пароль</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn-change">Обновить</button>
            </form>
        </div>
    </div>

    <!-- Проживание -->
    <!-- Проживание -->
    <div class="main-content" id="housing-section">
        <h2>Проживание</h2>

        <div class="housing-card">
            <h3>Проживание</h3>
            @if(Auth::user()->acceptedBooking)
                <p class="personal-location">
                    Корпус: {{ Auth::user()->acceptedBooking->building->name }},
                    Адрес: {{ Auth::user()->acceptedBooking->building->address }},
                    Этаж: {{ Auth::user()->acceptedBooking->room->floor }},
                    Комната: {{ Auth::user()->acceptedBooking->room->room_number }}
                </p>
            @else
                <p>Пока не заселен</p>
            @endif
            <button class="btn-finance" onclick="openChangeRoomModal()">Сменить комнату</button>
        </div>

        <div class="housing-card">
            <h3>Предстоящие оплаты</h3>
            <button class="btn-finance">Проверить финансовый кабинет</button>
        </div>
    </div>
    <script>
        // При загрузке страницы показываем "Главная" или "Личная информация"?
        // Пусть по умолчанию показываем главную (новости).
        document.addEventListener('DOMContentLoaded', function() {
            showNews();
        });
        function hideAllSections() {
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('housing-section').style.display = 'none';
            document.getElementById('personal-section').style.display = 'none';
        }
        function showNews() {
            hideAllSections()
            document.getElementById('news-section').style.display = 'block';
        }
        function showPersonal() {
            hideAllSections()
            document.getElementById('personal-section').style.display = 'block';
        }
        function showHousing() {
            hideAllSections()
            document.getElementById('housing-section').style.display = 'block';
        }
        function openPasswordModal() {
            document.getElementById('passwordModal').style.display = 'flex';
        }
        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }
        // Модальное окно: смена комнаты
        function openChangeRoomModal() {
            document.getElementById('changeRoomModal').style.display = 'flex';
        }
        function closeChangeRoomModal() {
            document.getElementById('changeRoomModal').style.display = 'none';
        }
        // Пример AJAX-загрузки этажей/комнат
        document.addEventListener('DOMContentLoaded', function() {
            const buildingSelect = document.getElementById('buildingSelect');
            const floorSelect = document.getElementById('floorSelect');
            const roomSelect = document.getElementById('roomSelect');

            buildingSelect.addEventListener('change', async function() {
                const buildingId = this.value;
                floorSelect.disabled = true;
                roomSelect.disabled = true;
                floorSelect.innerHTML = '<option>Загрузка...</option>';
                roomSelect.innerHTML = '<option>Сначала выберите этаж</option>';

                if (!buildingId) return;

                const response = await fetch(`/floors/${buildingId}`);
                const floors = await response.json();

                if (!floors || floors.length === 0) {
                    floorSelect.innerHTML = '<option>Нет доступных этажей</option>';
                    return;
                }

                floorSelect.innerHTML = '<option value="">Выберите этаж</option>';
                floors.forEach(f => {
                    floorSelect.innerHTML += `<option value="${f}">${f}</option>`;
                });
                floorSelect.disabled = false;
            });

            floorSelect.addEventListener('change', async function() {
                const buildingId = buildingSelect.value;
                const floor = this.value;
                roomSelect.disabled = true;
                roomSelect.innerHTML = '<option>Загрузка...</option>';

                if (!floor) return;

                const response = await fetch(`/rooms/${buildingId}/${floor}`);
                const rooms = await response.json();

                if (!rooms || rooms.length === 0) {
                    roomSelect.innerHTML = '<option>Нет доступных комнат</option>';
                    return;
                }

                roomSelect.innerHTML = '<option value="">Выберите комнату</option>';
                rooms.forEach(r => {
                    roomSelect.innerHTML += `<option value="${r.id}">${r.room_number}</option>`;
                });
                roomSelect.disabled = false;
            });
        });
    </script>
@endsection
