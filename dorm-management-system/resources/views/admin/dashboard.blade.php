@extends('layouts.app')

@section('content')
    <style>

        /* ========== ЛЕВАЯ ПАНЕЛЬ (САЙДБАР) ========== */
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
            font-size: 1.4rem;
            color: #4A4A4A;
        }
        .plus-button {
            background-color: #7e57c2;
            color: #fff;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-right: 1000px;

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
        /* ========== ДЕТАЛИ ПОЛЬЗОВАТЕЛЯ (скрытая секция) ========== */
        .user-details-section {
            display: none;
        }
        .user-details-card {
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            gap: 20px;
        }
        .user-photo {
            width: 180px;
            height: 180px;
            border-radius: 8px;
            overflow: hidden;
        }
        .user-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .user-info {
            flex: 1;
        }
        .user-info h2 {
            margin-bottom: 10px;
            font-size: 1.4rem;
        }
        .status {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
        }
        .user-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .user-form label {
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        .user-form input {
            padding: 8px;
            border: 1px solid #CCC;
            border-radius: 4px;
        }
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
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
        <form method="GET" action="{{ route('admin.users.index') }}" class="user-filter">
            <input type="text" name="filter_id" placeholder="ID" value="{{ request('filter_id') }}">
            <input type="text" name="filter_name" placeholder="ФИО" value="{{ request('filter_name') }}">
            <input type="text" name="filter_email" placeholder="E-mail" value="{{ request('filter_email') }}">
            <input type="text" name="filter_role" placeholder="Статус" value="{{ request('filter_role') }}">
            <button type="submit" class="btn-primary">Поиск</button>
        </form>

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
                    <!-- Делаем имя кликабельным, при клике -> viewUserDetail({{ $user->id }}) -->
                    <td>
                        <a href="javascript:void(0)"
                           style="text-decoration: none; color: #333;"
                           onclick="viewUserDetail({{ $user->id }})">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Нет пользователей</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <!-- ДЕТАЛИ ПОЛЬЗОВАТЕЛЯ (скрытая секция) -->
    <div class="main-content user-details-section" id="user-details-section" style="display: none;">
        <h2>Личные данные пользователя</h2>
        <div class="user-details-card">
            <!-- Фото -->
            <div class="user-photo" id="user-photo">
                <img src="https://via.placeholder.com/180x180?text=No+Photo" alt="User Photo">
            </div>
            <!-- Информация -->
            <div class="user-info">
                <h2 id="detail-name">Имя Фамилия</h2>
                <div class="status">Статус: <span id="detail-role"></span></div>
                <p>Корпус 1, этаж 2, комната 145 (пример)</p>

                <!-- Форма обновления -->
                <form id="userUpdateForm" class="user-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div>
                        <label>ID</label>
                        <input type="text" name="user_id" id="detail-user_id">
                    </div>
                    <div>
                        <label>Телефон</label>
                        <input type="text" name="phone" id="detail-phone">
                    </div>
                    <div>
                        <label>E-mail</label>
                        <input type="email" name="email" id="detail-email">
                    </div>
                    <div>
                        <label>Пароль</label>
                        <input type="password" disabled value="********">
                        <!-- Кнопка "Изменить пароль" => Можно сделать модалкой -->
                    </div>
                    <div>
                        <label>Фото</label>
                        <input type="file" name="photo">
                    </div>

                    <div class="actions" style="grid-column: 1 / span 2;">
                        <button type="submit" class="btn-success">Сохранить изменения</button>
                    </div>
                </form>

                <!-- Кнопка "Удалить пользователя" -->
                <form id="userDeleteForm"
                      action="{{ route('admin.users.destroy', $user->id) }}"
                      method="POST"
                      style="margin-top: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger"
                            onclick="return confirm('Точно удалить?')">
                        Удалить пользователя
                    </button>
                </form>

            </div>
        </div>
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
                <input type="text" name="name" class="form-control" required>

                <label class="form-label">ID</label>
                <input type="text" name="user_id" class="form-control" value="..." required>

                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="..." required>

                <label class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" required>

                <label class="form-label">Роль</label>
                <select name="role" class="form-control">
                    <option value="student" @if(old('role') === 'student') selected @endif>Студент</option>
                    <option value="manager" @if(old('role') === 'manager') selected @endif>Менеджер</option>
                    <option value="employee" @if(old('role') === 'employee') selected @endif>Сотрудник</option>
                    <option value="admin" @if(old('role') === 'admin') selected @endif>Админ</option>
                </select>
                <button type="submit" class="btn-success" style="margin-top: 10px;">Создать</button>
            </form>
        </div>
    </div>
    <script>
        // При загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
        showUsers();

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

        function hideAllSections() {
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('user-details-section').style.display = 'none';
        }
        function showUsers() {
            hideAllSections();
            document.getElementById('users-section').style.display = 'block';
        }

        function showNews() {
            hideAllSections();
            document.getElementById('news-section').style.display = 'block';
        }

        function CreateNews() {
            hideAllSections();
            document.getElementById('create-news-section').style.display = 'block';
        }

        function EditNews(id, title, content) {
            hideAllSections();
            document.getElementById('edit-news-section').style.display = 'block';
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-content').value = content;
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
        // Показать детальную информацию о пользователе (через AJAX)
        async function viewUserDetail(userId) {
            hideAllSections();

            // Пример: GET-запрос на admin/users/{id}/json (создайте такой маршрут!)
            // Или используйте admin.users.show => верните JSON
            let url = '/admin/users/' + userId + '/json'; // Пример
            try {
                let response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Ошибка при загрузке пользователя');
                }
                let data = await response.json();

                // Заполняем поля в user-details-section
                document.getElementById('detail-name').textContent = data.name || '';
                document.getElementById('detail-role').textContent = data.role || '';

                // Фото
                if (data.photo) {
                    document.getElementById('user-photo').innerHTML =
                        `<img src="/storage/${data.photo}" alt="User Photo">`;
                } else {
                    document.getElementById('user-photo').innerHTML =
                        `<img src="https://via.placeholder.com/180x180?text=No+Photo" alt="User Photo">`;
                }

                // Заполняем форму
                document.getElementById('detail-user_id').value = data.user_id || '';
                document.getElementById('detail-phone').value = data.phone || '';
                document.getElementById('detail-email').value = data.email || '';

                // Настраиваем action форм
                document.getElementById('userUpdateForm').action = '/admin/dashboard/users/' + data.id;
                document.getElementById('userDeleteForm').action = '/admin/dashboard/users/' + data.id;

                // Показываем секцию
                document.getElementById('user-details-section').style.display = 'block';
            } catch (error) {
                alert(error.message);
                showUsers();
            }
        }
    </script>
@endsection
