@extends('layouts.app')
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }
        .sidebar {
            position: fixed;
            top: 60px;
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
            cursor: pointer;
        }
        .sidebar-item:hover {
            background-color: #EFEFEF;
        }
        .main-content {
            margin-left: 200px;
            padding: 20px;
            padding-top: 80px;
        }
        .hidden {
            display: none;
        }
        .main-content {
            margin-left: 200px; /* отступ под ширину сайдбара */
            padding: 20px;
            padding-top: 80px;  /* чтобы контент не лез под шапку */
        }
        .main-content h2 {
            margin-bottom: 20px;
            color: #4A4A4A;
        }
        .main-content {
             margin-left: 200px; /* Если у тебя сайдбар 200px */
             padding-top: 80px; /* чтобы не залезать под шапку */
             background-color: #F5F5F5;
             min-height: calc(100vh - 60px);
         }
        .main-content {
            margin-left: 200px;
            padding: 20px;
            padding-top: 80px;
        }
        .personal-actions {
            margin-top: 20px;
        }
        .personal-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #CCC;
            border-radius: 4px;
        }       /* Карточка «Личные данные» */
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
            height: 550px;
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
    </style>

    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>Главная</span>
        </div>
        <a class="sidebar-item" onclick="showPersonal()">
            <i class="fas fa-user"></i>
            <span>Личная информация</span>
        </a>
        @if(Auth::user()->role === 'student')
        <div class="sidebar-item">
            <i class="fas fa-wrench"></i>
            <span><a href="{{ route('employee.requests') }}">Просмотр заявок</a></span>
        </div>
    </div>

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
                    <div class="personal-status">{{ Auth::user()->job_type }}</div>

                    <form class="personal-form" action="{{route('employee.updateProfile')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label>E-Mail</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div>
                            <label>Номер телефона</label>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                        </div>
                        <div>
                            <label for="job_type">Тип работы</label>
                            <input type="text" name="job_type" value="{{old('job_type', $user->employee->job_type ?? 'Не выбран')}}">
                        </div>
                        <div>
                            <label>Пароль</label>
                            <!-- Вместо реального пароля показываем звездочки -->
                            <div style="display: flex; gap: 10px;">
                                <input type="password" value="********" disabled>
                                <!-- Кнопка, открывающая модальное окно -->
                                <button type="button" class="btn btn-secondary" onclick="openPasswordModal()">
                                    Изменить
                                </button>
                            </div>
                        </div>
                        <div>
                            <label>Фото</label>
                            <input type="file" name="photo">
                        </div>

                        <div class="personal-actions">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="passwordModal">
        <div class="modal-content">
            <button class="close-button" onclick="closePasswordModal()">&times;</button>
            <h2>Изменить пароль</h2>

            @if(session('password_success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px;">
                    {{ session('password_success') }}
                </div>
            @endif
            <!-- Форма для смены пароля -->
            <form action="{{route('employee.updatePassword')}}" method="POST">
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
                <button type="submit" class="btn btn-success">Обновить</button>
            </form>
        </div>
    </div>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            function hideAllSections() {
                document.querySelectorAll(".main-content").forEach(section => {
                    section.style.display = "none";
                });
            }

            window.showPersonal = function () {
                hideAllSections();
                document.getElementById("personal-section").style.display = "block";
            };
        });

        function showSection(sectionId) {
            document.querySelectorAll('.main-content').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId).classList.remove('hidden');
        }

        function openPasswordModal() {
            document.getElementById('passwordModal').style.display = 'flex';
        }
        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }
        function showNews() {
            document.getElementById('news-section').style.display = 'block';
        }
    </script>
@endsection
