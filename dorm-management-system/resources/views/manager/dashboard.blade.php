@extends('layouts.app')

@section('content')
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

        /* ========== ЛЕВАЯ ПАНЕЛЬ (САЙДБАР) ========== */
        .sidebar {
            position: fixed;
            top: 60px; /* высота верхней панели */
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
        .sidebar-item i {
            font-size: 18px;
            color: #4A4A4A;
        }

        /* ========== ОСНОВНОЙ КОНТЕНТ ========== */
        .main-content {
            margin-left: 200px; /* отступ под ширину сайдбара */
            padding: 20px;
            padding-top: 80px; /* чтобы контент не лез под шапку */
            background-color: #F5F5F5;
            min-height: calc(100vh - 60px);
        }
        .main-content h2 {
            margin-bottom: 20px;
            color: #4A4A4A;
        }

        /* ========== ТАБЛИЦЫ, ФОРМЫ ========== */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #DDD;
            text-align: left;
        }
        .table th {
            background-color: #F9F9F9;
        }
        .form-label {
            font-weight: bold;
            margin-top: 8px;
            display: block;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            padding: 8px 16px;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 8px 16px;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* ========== СТИЛИ ДЛЯ НОВОСТЕЙ ========== */
        .news-item {
            background-color: #B0A5D7; /* Фиолетовый */
            padding: 35px;
            color: #fff;
            max-width: 1200px;
            height: 250px;
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

        /* Заголовок + кнопка \"+\" */
        .heading-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .heading-row h2 {
            font-size: 1.2rem;
            color: #4A4A4A;
        }
        .plus-button {
            background-color: #7e57c2;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        .plus-button:hover {
            background-color: #6f42c1;
        }

        /* Фильтр (ID, ФИО, E-mail, Статус) */
        .user-filter {
            display: flex;
            gap: 8px;
            margin-bottom: 1rem;
        }
        .user-filter input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        /* Таблица пользователей */
        .users-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 8px;
            overflow: hidden;
        }
        .users-table th, .users-table td {
            padding: 12px;
            border-bottom: 1px solid #EEE;
            font-size: 0.95rem;
            color: #333;
        }
        .users-table th {
            background-color: #F9F9F9;
            text-align: left;
        }

        /* Кнопка выхода (с иконкой) */
        .logout-form button {
            background: none;
            border: none;
            color: #333;
            font-size: 0.9rem;
            cursor: pointer;
            gap: 6px;
        }
        .logout-form button:hover {
            text-decoration: underline;
        }
        a.my-span-style {
            text-decoration: none;
            color: #333;
        }
        a.my-span-style:hover {
            text-decoration: none;
            color: #555;
        }

        /* Модальное окно */
        .modal-overlay {
            display: none; /* скрыто по умолчанию */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5); /* затемнение фона */
            align-items: center;
            justify-content: center;
            z-index: 9999; /* поверх всего */
        }
        .modal-content {
            background: #fff;
            width: 500px; /* ширина модального окна */
            padding: 20px;
            border-radius: 8px;
            position: relative;
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

    <!-- САЙДБАР -->
    <div class="sidebar">
        <div class="sidebar-item" onclick="showUsers()">
            <i class="fas fa-user"></i>
            <span>Пользователи</span>
        </div>
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>Новости</span>
        </div>
        <div class="sidebar-item">
            <i class="fas fa-store"></i>
            <span>Купи-Продай</span>
        </div>
    </div>

    <!-- СЕКЦИЯ НОВОСТЕЙ (по умолчанию видна) -->
    <div class="main-content" id="news-section" style="display: block;">
        <div class="container">
            <h1>Новости</h1>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Кнопка для показа формы создания новости -->
            <a href="javascript:void(0)" onclick="CreateNews()" class="btn btn-primary mb-3">Создать новость</a>

            <table class="table">
                <thead>
                <tr>
                    <th>Заголовок</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($newsList as $news)
                    <tr>
                        <td>{{ $news->title }}</td>
                        <td>{{ $news->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                    onclick='EditNews({{ $news->id }}, {!! json_encode($news->title) !!}, {!! json_encode(strip_tags($news->content)) !!})'>
                                Редактировать
                            </button>
                            <form action="{{ route('admin.news.destroy', $news->id) }}"
                                  method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Точно удалить?')" >Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">Новостей нет</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- СЕКЦИЯ СОЗДАНИЯ НОВОСТИ (скрыта по умолчанию) -->
    <div class="main-content" id="create-news-section" style="display: none;">
        <div class="container">
            <h1>Создать новость</h1>
            <div class="create-news-section">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">Заголовок</label>
                    <input type="text" name="title" class="form-control" required>

                    <label class="form-label">Содержание</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>

                    <label class="form-label">Картинка (опционально)</label>
                    <input type="file" name="image" class="form-control">

                    <button type="submit" class="btn-success" >Создать</button>
                </form>
            </div>
        </div>
    </div>

    <!-- СЕКЦИЯ РЕДАКТИРОВАНИЯ НОВОСТИ (скрыта) -->
    <div class="main-content" id="edit-news-section" style="display: none;">
        <div class="container">
            <h1>Редактировать новость</h1>
            <div class="create-news-section">
                <form id="editNewsForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <label class="form-label">Заголовок</label>
                    <input type="text" id="edit-title" name="title" class="form-control" required>

                    <label class="form-label">Содержание</label>
                    <textarea id="edit-content" name="content" class="form-control" rows="5" required></textarea>

                    <label class="form-label">Картинка (опционально)</label>
                    <input type="file" name="image" class="form-control">

                    <button type="submit" class="btn-success" >Сохранить</button>
                    <button type="button" class="plus-button" onclick="cancelEdit()">Отмена</button>
                </form>
            </div>
        </div>
    </div>

    <!-- СЕКЦИЯ ПОЛЬЗОВАТЕЛЕЙ (скрыта по умолчанию) -->
    <div class="main-content" id="users-section" style="display: none;">
        <div class="heading-row">
            <h2>Список пользователей</h2>
            <button class="plus-button" onclick="openModal()">+</button>
        </div>
        <!-- Фильтр / поиск -->
        <div class="user-filter">
            <input type="text" placeholder="ID">
            <input type="text" placeholder="ФИО">
            <input type="text" placeholder="E-mail">
            <input type="text" placeholder="Статус">
        </div>

        <!-- Таблица пользователей -->
        <table class="users-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>E-mail</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Нет пользователей</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- МОДАЛЬНОЕ ОКНО (создание пользователя) -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-content">
            <button class="close-button" onclick="closeModal()">×</button>
            <h2>Создать пользователя</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        <p>{{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <label class="form-label">ФИО</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>

                <label class="form-label">ID</label>
                <input type="text" name="user_id" class="form-control" value="{{ old('user_id') }}" required>

                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>

                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required>

                <label class="form-label">Роль</label>
                <select name="role" class="form-control">
                    <option value="student" @if(old('role') === 'student') selected @endif>Студент</option>
                    <option value="manager" @if(old('role') === 'manager') selected @endif>Менеджер</option>
                    <option value="admin" @if(old('role') === 'admin') selected @endif>Админ</option>
                </select>
                <button type="submit" class="btn-success" style="margin-top: 10px;">Создать</button>
            </form>
        </div>
    </div>

    <script>
        // При загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            showNews();

            @if($errors->any())
            openModal();
            @endif

            @if(session('successType') === 'user_created')
            closeModal();
            showUsers();
            @elseif(session('successType') === 'news_created')
            // Если надо, можно вызвать showNews() или
            // просто оставить всё, как есть.
            showNews();
            @endif
        });


        function showUsers() {
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'block';
        }

        function showNews() {
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('news-section').style.display = 'block';
        }

        function CreateNews() {
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'block';
        }

        function EditNews(id, title, content) {
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'block';
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-content').value = content;
            // Меняем action формы редактирования
            document.getElementById('editNewsForm').action = '{{ url("admin/news") }}/' + id;
        }

        function cancelEdit() {
            document.getElementById('edit-news-section').style.display = 'none';
            showNews();
        }

        function openModal() {
            document.getElementById('modalOverlay').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalOverlay').style.display = 'none';
        }
    </script>
@endsection
