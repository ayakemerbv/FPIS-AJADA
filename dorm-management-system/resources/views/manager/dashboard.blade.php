@extends('layouts.app')

@section('content')
    <style>


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
            background-color: #7e57c2;
            border: none;
            padding: 8px 16px;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: #6f42c1;
        }


        /* Заголовок + кнопка "+" */
        .heading-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .heading-row h2 {
            font-size: 2rem;
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
        <!-- Кнопка "Главная" -> показывает #see-news-section -->
        <div class="sidebar-item" onclick="seeNews()">
            <i class="fas fa-home"></i>
            <span>Лента</span>
        </div>
        <!-- Кнопка "Новости" -> показывает #news-section (CRUD новостей) -->
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-newspaper"></i>
            <span>Новости</span>
        </div>
        <!-- Кнопка "Пользователи" -->
        <div class="sidebar-item" onclick="showUsers()">
            <i class="fas fa-user"></i>
            <span>Пользователи</span>
        </div>
        <div class="sidebar-item" onclick="showRequests()">
            <i class="fas fa-bars"></i>
            <span>Заявки</span>
        </div>
    </div>

    <!-- Блок с новостями (ЛЕНТА) -->
    <div class="main-content" id="see-news-section" style="display: none;">
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

    <!-- СЕКЦИЯ "Новости" (CRUD), по умолчанию скрыта -->
    <div class="main-content" id="news-section" style="display: none;">
        <div class="container">
            <h2>Управление новостями</h2>
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
                            <form action="{{ route('manager.news.destroy', $news->id) }}"
                                  method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Точно удалить?')">Удалить</button>
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
            <h2>Создать новость</h2>
            <div class="create-news-section">
                <form action="{{ route('manager.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">Заголовок</label>
                    <input type="text" name="title" class="form-control" required>

                    <label class="form-label">Содержание</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>

                    <label class="form-label">Картинка (опционально)</label>
                    <input type="file" name="image" class="form-control">

                    <button type="submit" class="btn-success">Создать</button>
                </form>
            </div>
        </div>
    </div>

    <!-- СЕКЦИЯ РЕДАКТИРОВАНИЯ НОВОСТИ (скрыта) -->
    <div class="main-content" id="edit-news-section" style="display: none;">
        <div class="container">
            <h2>Редактировать новость</h2>
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

                    <button type="submit" class="btn-success">Сохранить</button>
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

            <form action="{{ route('manager.users.store') }}" method="POST">
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

    <div class="main-content" id="request-section" style="display: none;">
        <h2>Заявки на заселение</h2>

        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width:100%; border-collapse: collapse;">
            <thead>
            <tr>
                <th>Студент</th>
                <th>Корпус</th>
                <th>Этаж</th>
                <th>Комната</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $req)
                <tr style="border-bottom: 1px solid #ccc;">
                    <td>{{ $req->user->name }}</td>
                    <td>{{ $req->building->name}}</td>
                    <td>{{ $req->floor }}</td>
                    <td>{{ $req->room->room_number }}</td>
                    <td>{{ $req->status }}</td>
                    <td>
                        <a href="{{ route('booking.accept', $req->id) }}"
                           style="color: green; text-decoration: none; margin-right: 10px;">
                            Принять
                        </a>
                        <a href="{{ route('booking.reject', $req->id) }}"
                           style="color: red; text-decoration: none;">
                            Отклонить
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        // По умолчанию: "Главная" -> seeNews()
        document.addEventListener('DOMContentLoaded', function() {
            seeNews();

            @if($errors->any())
            openModal();
            @endif

            @if(session('successType') === 'user_created')
            closeModal();
            showUsers();
            @elseif(session('successType') === 'news_created')
            showNews();
            @endif
        });

        // "Главная" (Лента) -> показываем #see-news-section
        function seeNews() {
            // Показываем ленту
            document.getElementById('see-news-section').style.display = 'block';
            document.getElementById('request-section').style.display = 'none';
            // Скрываем всё остальное
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
        }

        // "Новости" (CRUD) -> показываем #news-section
        function showNews() {
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('request-section').style.display = 'none';
            document.getElementById('news-section').style.display = 'block';
        }

        // "Пользователи"
        function showUsers() {
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('request-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'block';
        }

        // Кнопка "Создать новость"
        function CreateNews() {
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('request-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'block';
        }

        // Кнопка "Редактировать"
        function EditNews(id, title, content) {
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'block';
            document.getElementById('request-section').style.display = 'none';
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-content').value = content;
            document.getElementById('editNewsForm').action = '{{ url("admin/news") }}/' + id;
        }
        function showRequests() {
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('request-section').style.display = 'block';
        }


        // Кнопка "Отмена" (редактирование)
        function cancelEdit() {
            document.getElementById('edit-news-section').style.display = 'none';
            showNews();
        }

        // Модальное окно (создание пользователя)
        function openModal() {
            document.getElementById('modalOverlay').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('modalOverlay').style.display = 'none';
        }
    </script>
@endsection
