@extends('layouts.app')

@section('content')
   <style>:root {
           --sidebar-width: 200px;
           --header-height: 60px;
           --primary-color: #7e57c2;
           --primary-hover: #6f42c1;
           --success-color: #28a745;
           --danger-color: #a7284a;
           --success-hover: #218838;
           --text-color: #333;
           --border-color: #DDD;
           --bg-light: #F9F9F9;
           --bg-main: #F5F5F5;
       }

       /* Sidebar */
       .sidebar {
           position: fixed;
           top: var(--header-height);
           left: 0;
           width: var(--sidebar-width);
           height: calc(100vh - var(--header-height));
           background-color: #fff;
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
           background-color: #efefef;
       }
       .sidebar-item i {
           font-size: 18px;
       }

       /* Main Content */
       .main-content {
           margin-left: var(--sidebar-width);
           padding: 80px 20px 20px;
           background-color: var(--bg-main);
           min-height: calc(100vh - var(--header-height));
       }
       .main-content h2 {
           margin-bottom: 20px;
           color: var(--text-color);
       }

       /* Table */
       .table, .users-table {
           width: 100%;
           border-collapse: collapse;
           background-color: #fff;
       }
       .table th, .table td, .users-table th, .users-table td {
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

       /* Form */
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

       /* Buttons */
       .btn-success, .btn-primary, .plus-button {
           padding: 8px 16px;
           border-radius: 4px;
           border: none;
           color: #fff;
           cursor: pointer;
       }
       .btn-danger, .btn-primary, .plus-button {
           padding: 8px 16px;
           border-radius: 4px;
           border: none;
           color: #fff;
           cursor: pointer;
       }
       .btn-success {
           background-color: var(--success-color);
       }
       .btn-danger {
           background-color: var(--danger-color);
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

       /* Utility */
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

       /* Modal */
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
       /* Карточка «Личные данные» */
       .personal-card {
           background-color: #FFF;
           border: 1px solid #DDD;
           border-radius: 8px;
           padding: 20px;
       }
       .personal-content {
           display: flex;
           gap: 20px;
       }
       .personal-photo {
           width: 180px;
           height: 180px;
           border-radius: 8px;
           overflow: hidden;
       }
       .personal-photo img {
           width: 100%;
           height: 100%;
           object-fit: cover;
       }
       .personal-info {
           flex: 1;
       }
       .personal-name {
           font-size: 1.1rem;
           font-weight: bold;
           margin-bottom: 4px;
       }
       .personal-status,
       .personal-location {
           font-size: 0.9rem;
           color: #666;
           margin-bottom: 8px;
       }
       /* Форма личных данных */
       .personal-form {
           display: grid;
           grid-template-columns: 1fr 1fr;
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
       .personal-actions {
           margin-top: 20px;
       }
   </style>

   <!-- Sidebar -->
   <div class="sidebar">
       <div class="sidebar-item" onclick="showNews()"><i class="fas fa-home"></i><span>{{ __('messages.main') }}</span></div>
       <div class="sidebar-item" onclick="seeNews()"><i class="fas fa-newspaper"></i><span>{{ __('messages.news') }}</span></div>
       <div class="sidebar-item" onclick="showPersonal()"><i class="fas fa-user"></i><span>{{ __('messages.personal_data') }}</span></div>
       <div class="sidebar-item" onclick="showUsers()"><i class="fas fa-user"></i><span>{{ __('messages.users') }}</span></div>
       <div class="sidebar-item" onclick="showRequests()"><i class="fas fa-bars"></i><span>{{ __('messages.requests') }}</span></div>
   </div>


   <!-- СЕКЦИЯ "Новости" (CRUD), по умолчанию скрыта -->
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
                           <form action="{{ route('manager.news.destroy', $news->id) }}"
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
   <!-- СЕКЦИЯ СОЗДАНИЯ НОВОСТИ (скрыта по умолчанию) -->
   <div class="main-content" id="create-news-section" style="display: none;">
       <div class="container">
           <h2>{{ __('messages.create_news') }}</h2>
           <div class="create-news-section">
               <form action="{{ route('manager.news.store') }}" method="POST" enctype="multipart/form-data">
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
   <!-- СЕКЦИЯ РЕДАКТИРОВАНИЯ НОВОСТИ (скрыта) -->
   <div class="main-content" id="edit-news-section" style="display: none;">
       <div class="container">
           <h2>{{ __('messages.edit_news') }}</h2>
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
   <!-- ===== SECTION: Личные данные ===== -->
   <div class="main-content" id="personal-section">
       <div class="container">
           <h2>{{ __('messages.personal_data') }}</h2>
           <div class="personal-card">
               <div class="personal-content">
                   <div class="personal-photo">
                       @if(Auth::user()->photo)
                           <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ __('messages.user_photo') }}">
                       @else
                           <img src="https://via.placeholder.com/180x180?text=No+Photo" alt="{{ __('messages.user_photo') }}">
                       @endif
                   </div>
                   <div class="personal-info">
                       <div class="personal-name">{{ Auth::user()->name }}</div>
                       <div class="personal-status">{{ Auth::user()->job_type ?? '' }}</div>

                       <form class="personal-form" action="{{ route('manager.updateProfile') }}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <div>
                               <label>{{ __('messages.email') }}</label>
                               <input type="email" value="{{ Auth::user()->email }}" disabled>
                           </div>
                           <div>
                               <label>{{ __('messages.phone_number') }}</label>
                               <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                           </div>
                           <div>
                               <label>{{ __('messages.photo') }}</label>
                               <input type="file" name="photo">
                           </div>
                           <div>
                               <label>{{ __('messages.password') }}</label>
                               <div style="display: flex; gap: 10px;">
                                   <input type="password" value="********" disabled>
                                   <button type="button" class="btn btn-secondary" onclick="openPasswordModal()">
                                       {{ __('messages.change') }}
                                   </button>
                               </div>
                           </div>

                           <div class="personal-actions">
                               <button type="submit" class="btn btn-success">{{ __('messages.save') }}</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- ========== Секция пользователей (скрыта) ========== -->
   <div class="main-content" id="users-section" style="display: none;">
       <!-- Фильтр / поиск -->
       <form method="GET" action="{{ route('manager.users.index') }}" class="user-filter">
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
   <!-- СЕКЦИЯ заявки на заселение -->
   <div class="main-content" id="request-section" style="display: none;">
       <h2>{{ __('messages.requests') }}</h2>
       @if(session('success'))
           <div style="background-color: #d4edda; color: #155724; padding: 10px;">
               {{ session('success') }}
           </div>
       @endif
       <table style="width:100%; border-collapse: collapse;">
           <thead>
           <tr>
               <th>{{ __('messages.student') }}</th>
               <th>{{ __('messages.building') }}</th>
               <th>{{ __('messages.floor') }}</th>
               <th>{{ __('messages.room') }}</th>
               <th>{{ __('messages.status') }}</th>
               <th>{{ __('messages.actions') }}</th>
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
                           {{ __('messages.accept') }}
                       </a>
                       <a href="{{ route('booking.reject', $req->id) }}"
                          style="color: red; text-decoration: none;">
                           {{ __('messages.reject') }}
                       </a>
{{--                       <a href="{{ route('booking.reject', $req->id) }}"--}}
{{--                          style="color: red; text-decoration: none;">--}}
{{--                           {{ __('messages.in_review') }}--}}
{{--                       </a>--}}

                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
   </div>

   <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNews();
            @if($errors->any())
            openModal();
            @endif
            @if(session('successType') === 'news_created')
            seeNews();
            @elseif(session('successType') === 'news_updated')
            seeNews();
            @elseif(session('successType') === 'news_deleted')
            seeNews();
            @elseif(session('successType') === 'user_searched')
            showUsers();
            @elseif(session('successType') === 'request_accepted')
            showRequests();
            @endif
        });
        function showPersonal() {
            hideAllSections();
            document.getElementById('personal-section').style.display = 'block';
        }
        function showUsers() {
            hideAllSections();
            document.getElementById('users-section').style.display = 'block';
        }
        async function viewUserDetail(userId) {
            hideAllSections();
            let url = '/manager/users/' + userId + '/json';
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
                document.getElementById('userUpdateForm').action = '/manager/dashboard/users/' + data.id;
                document.getElementById('userDeleteForm').action = '/manager/dashboard/users/' + data.id;
                document.getElementById('user-details-section').style.display = 'block';
            } catch (error) {
                alert(error.message);
                showUsers();
            }
        }
        function openModal() {
            document.getElementById('modalOverlay').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('modalOverlay').style.display = 'none';
        }
        function seeNews() {
            hideAllSections()
            document.getElementById('news-section').style.display = 'block';
        }
        function CreateNews() {
            hideAllSections()
            document.getElementById('create-news-section').style.display = 'block';
        }
        function EditNews(id, title, content) {
            hideAllSections();
            document.getElementById('edit-news-section').style.display = 'block';
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-content').value = content;
            document.getElementById('editNewsForm').action = '/manager/dashboard/news/' + id;
        }
        function showRequests() {
            hideAllSections();
            document.getElementById('request-section').style.display = 'block';
        }
        function cancelEdit() {
            document.getElementById('edit-news-section').style.display = 'none';
            showNews();
        }
        function hideAllSections() {
            document.getElementById('news-section').style.display = 'none';
            document.getElementById('users-section').style.display = 'none';
            document.getElementById('user-details-section').style.display = 'none';
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('create-news-section').style.display = 'none';
            document.getElementById('personal-section').style.display = 'none';
            document.getElementById('edit-news-section').style.display = 'none';
            document.getElementById('request-section').style.display = 'none';
        }
    </script>
@endsection
