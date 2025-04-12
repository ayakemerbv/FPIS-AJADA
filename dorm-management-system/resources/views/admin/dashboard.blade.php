@extends('layouts.app')

@section('content')
    <style>
        :root {
            --sidebar-width: 200px;
            --header-height: 60px;
            --primary-color: #7e57c2;
            --primary-hover: #6f42c1;
            --success-color: #28a745;
            --success-hover: #218838;
            --text-color: #333;
            --border-color: #DDD;
            --bg-light: #F9F9F9;
            --bg-main: #F5F5F5;
        }

        /* ========== Сайдбар ========== */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background-color: #FFF;
            border-right: 1px solid var(--border-color);
            padding-top: 20px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            cursor: pointer;
        }
        .sidebar-item:hover {
            background-color: #EFEFEF;
        }
        .sidebar-item i {
            font-size: 18px;
            color: var(--text-color);
        }

        /* ========== Основной контент ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 80px 20px 20px;
            background-color: var(--bg-main);
            min-height: calc(100vh - var(--header-height));
        }
        .main-content h2,
        .main-content h1 {
            margin-bottom: 20px;
            color: var(--text-color);
        }

        /* ========== Таблицы и формы ========== */
        .table, .users-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFF;
        }
        .table th, .table td,
        .users-table th, .users-table td {
            padding: 12px;
            border: 1px solid var(--border-color);
            text-align: left;
            font-size: 0.95rem;
            color: var(--text-color);
        }
        .table th, .users-table th {
            background-color: var(--bg-light);
        }
        .users-table tr:last-child td {
            border-bottom: none;
        }
        .form-label {
            font-weight: bold;
            display: block;
            margin: 8px 0 4px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* ========== Кнопки ========== */
        .btn-success, .btn-primary, .plus-button {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        .btn-success {
            background-color: var(--success-color);
        }
        .btn-success:hover {
            background-color: var(--success-hover);
        }
        .btn-primary, .plus-button {
            background-color: var(--primary-color);
        }
        .btn-primary:hover, .plus-button:hover {
            background-color: var(--primary-hover);
        }

        /* ========== Утилиты ========== */
        .heading-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
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
        .logout-form button {
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 0.9rem;
            cursor: pointer;
            gap: 6px;
        }
        .logout-form button:hover {
            text-decoration: underline;
        }
        a.my-span-style {
            text-decoration: none;
            color: var(--text-color);
        }
        a.my-span-style:hover {
            color: #555;
        }

        /* ========== Стили для новостей ========== */
        .news-item {
            background-color: #B0A5D7;
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

        /* ========== Заголовок и кнопка "+" ========== */
        .heading-row h2 {
            font-size: 1.4rem;
            color: var(--text-color);
        }
        .plus-button {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-right: 1000px;
        }
        .plus-button:hover {
            background-color: var(--primary-hover);
        }

        /* ========== Модальное окно ========== */
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
            width: 500px;
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

        /* ========== Детали пользователя ========== */
        .user-details-section {
            display: none;
        }
        .user-details-card {
            background-color: #FFF;
            border: 1px solid var(--border-color);
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

    <div class="sidebar">
        <div class="sidebar-item" onclick="showUsers()">
            <i class="fas fa-user"></i>
            <span>{{ __('messages.users') }}</span>
        </div>
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>{{ __('messages.news') }}</span>
        </div>
    </div>

    <!-- ========== Блок с новостями (Лента) ========== -->
    <div class="main-content" id="see-news-section" style="display: none;">
        <h2>{{ __('messages.news') }}</h2>
        @isset($newsList)
            @forelse($newsList as $news)
                <div class="news-item">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ __('messages.news_image') }}">
                    @endif
                    <h3>{{ $news->title }}</h3>
                    <p>{{ $news->content }}</p>
                    <small>{{ $news->created_at->format('d.m.Y H:i') }}</small>
                </div>
            @empty
                <p>{{ __('messages.no_news') }}</p>
            @endforelse
        @endisset
    </div>

    <!-- ========== Секция "Новости" (CRUD) ========== -->
    <div class="main-content" id="news-section" style="display: none;">
        <div class="container">
            <h2>{{ __('messages.manage_news') }}</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Кнопка для показа формы создания новости -->
            <a href="javascript:void(0)" onclick="CreateNews()" class="btn btn-primary mb-3">{{ __('messages.create_news') }}</a>

            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('messages.title') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.actions') }}</th>
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
                                {{ __('messages.edit') }}
                            </button>
                            <form action="{{ route('admin.news.destroy', $news->id) }}"
                                  method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.confirm_delete') }}')">{{ __('messages.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">{{ __('messages.no_news') }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========== Секция создания новости (скрыта) ========== -->
    <div class="main-content" id="create-news-section" style="display: none;">
        <div class="container">
            <h1>{{ __('messages.create_news') }}</h1>
            <div class="create-news-section">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">{{ __('messages.title') }}</label>
                    <input type="text" name="title" class="form-control" required>

                    <label class="form-label">{{ __('messages.content') }}</label>
                    <textarea name="content" class="form-control" rows="5" required></textarea>

                    <label class="form-label">{{ __('messages.image_optional') }}</label>
                    <input type="file" name="image" class="form-control">

                    <button type="submit" class="btn-success">{{ __('messages.create') }}</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== Секция редактирования новости (скрыта) ========== -->
    <div class="main-content" id="edit-news-section" style="display: none;">
        <div class="container">
            <h1>{{ __('messages.edit_news') }}</h1>
            <div class="create-news-section">
                <form id="editNewsForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <label class="form-label">{{ __('messages.title') }}</label>
                    <input type="text" id="edit-title" name="title" class="form-control" required>

                    <label class="form-label">{{ __('messages.content') }}</label>
                    <textarea id="edit-content" name="content" class="form-control" rows="5" required></textarea>

                    <label class="form-label">{{ __('messages.image_optional') }}</label>
                    <input type="file" name="image" class="form-control">

                    <button type="submit" class="btn-success">{{ __('messages.save') }}</button>
                    <button type="button" class="plus-button" onclick="cancelEdit()">{{ __('messages.cancel') }}</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== Секция пользователей (скрыта) ========== -->
    <div class="main-content" id="users-section" style="display: none;">
        <div class="heading-row">
            <h2>{{ __('messages.user_list') }}</h2>
            <button class="plus-button" onclick="openModal()">+</button>
        </div>
        <!-- Фильтр / поиск -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="user-filter">
            <input type="text" name="filter_id" placeholder="{{ __('messages.id') }}" value="{{ request('filter_id') }}">
            <input type="text" name="filter_name" placeholder="{{ __('messages.full_name') }}" value="{{ request('filter_name') }}">
            <input type="text" name="filter_email" placeholder="{{ __('messages.email') }}" value="{{ request('filter_email') }}">
            <input type="text" name="filter_role" placeholder="{{ __('messages.status') }}" value="{{ request('filter_role') }}">
            <button type="submit" class="btn-primary">{{ __('messages.search') }}</button>
        </form>

        <!-- Таблица пользователей -->
        <table class="users-table">
            <thead>
            <tr>
                <th>{{ __('messages.id') }}</th>
                <th>{{ __('messages.full_name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.status') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>
                        <a href="javascript:void(0)"
                           style="text-decoration: none; color: var(--text-color);"
                           onclick="viewUserDetail({{ $user->id }})">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @empty
                <tr><td colspan="4">{{ __('messages.no_users') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- ========== Секция деталей пользователя (скрыта) ========== -->
    <div class="main-content user-details-section" id="user-details-section" style="display: none;">
        <h2>{{ __('messages.user_details') }}</h2>
        <div class="user-details-card">
            <!-- Фото -->
            <div class="user-photo" id="user-photo">
                <img src="https://via.placeholder.com/180x180?text=No+Photo" alt="{{ __('messages.user_photo') }}">
            </div>
            <!-- Информация -->
            <div class="user-info">
                <h2 id="detail-name">{{ __('messages.full_name') }}</h2>
                <div class="status">{{ __('messages.status') }}: <span id="detail-role"></span></div>
                <p>{{ __('messages.address_example') }}</p>

                <!-- Форма обновления -->
                <form id="userUpdateForm" class="user-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div>
                        <label>{{ __('messages.id') }}</label>
                        <input type="text" name="user_id" id="detail-user_id">
                    </div>
                    <div>
                        <label>{{ __('messages.phone') }}</label>
                        <input type="text" name="phone" id="detail-phone">
                    </div>
                    <div>
                        <label>{{ __('messages.email') }}</label>
                        <input type="email" name="email" id="detail-email">
                    </div>
                    <div>
                        <label>{{ __('messages.password') }}</label>
                        <input type="password" disabled value="********">
                    </div>
                    <div>
                        <label>{{ __('messages.photo') }}</label>
                        <input type="file" name="photo">
                    </div>

                    <div class="actions" style="grid-column: 1 / span 2;">
                        <button type="submit" class="btn-success">{{ __('messages.save_changes') }}</button>
                    </div>
                </form>

                <!-- Кнопка "Удалить пользователя" -->
                <form id="userDeleteForm"
                      action="{{ route('admin.users.destroy', $user->id) }}"
                      method="POST"
                      style="margin-top: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                        {{ __('messages.delete_user') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== Модальное окно (создание пользователя) ========== -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-content">
            <button class="close-button" onclick="closeModal()">×</button>
            <h2>{{ __('messages.create_user') }}</h2>
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
                <label class="form-label">{{ __('messages.full_name') }}</label>
                <input type="text" name="name" class="form-control" required>
                <label class="form-label">{{ __('messages.id') }}</label>
                <input type="text" name="user_id" class="form-control" value="..." required>
                <label class="form-label">{{ __('messages.email') }}</label>
                <input type="email" name="email" class="form-control" value="..." required>
                <label class="form-label">{{ __('messages.password') }}</label>
                <input type="password" name="password" class="form-control" required>
                <label class="form-label">{{ __('messages.role') }}</label>
                <select name="role" class="form-control">
                    <option value="student" @if(old('role') === 'student') selected @endif>{{ __('messages.student') }}</option>
                    <option value="manager" @if(old('role') === 'manager') selected @endif>{{ __('messages.manager') }}</option>
                    <option value="employee" @if(old('role') === 'employee') selected @endif>{{ __('messages.employee') }}</option>
                    <option value="admin" @if(old('role') === 'admin') selected @endif>{{ __('messages.admin') }}</option>
                </select>
                <button type="submit" class="btn-success" style="margin-top: 10px;">{{ __('messages.create') }}</button>
            </form>
        </div>
    </div>


    <script>
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
        async function viewUserDetail(userId) {
            hideAllSections();
            let url = '/admin/users/' + userId + '/json';
            try {
                let response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Ошибка при загрузке пользователя');
                }
                let data = await response.json();
                document.getElementById('detail-name').textContent = data.name || '';
                document.getElementById('detail-role').textContent = data.role || '';
                if (data.photo) {
                    document.getElementById('user-photo').innerHTML =
                        `<img src="/storage/${data.photo}" alt="User Photo">`;
                } else {
                    document.getElementById('user-photo').innerHTML =
                        `<img src="https://via.placeholder.com/180x180?text=No+Photo" alt="User Photo">`;
                }
                document.getElementById('detail-user_id').value = data.user_id || '';
                document.getElementById('detail-phone').value = data.phone || '';
                document.getElementById('detail-email').value = data.email || '';
                document.getElementById('userUpdateForm').action = '/admin/dashboard/users/' + data.id;
                document.getElementById('userDeleteForm').action = '/admin/dashboard/users/' + data.id;
                document.getElementById('user-details-section').style.display = 'block';
            } catch (error) {
                alert(error.message);
                showUsers();
            }
        }
    </script>
@endsection
