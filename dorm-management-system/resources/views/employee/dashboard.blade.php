@extends('layouts.app')
@section('content')
    <style>
        /* Сброс стилей и базовые стили */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }
        .container {
            max-width: 960px;
            margin-left: -20px;
        }
        /* Сайдбар (не меняется при переключении секций) */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 200px;
            height: calc(100vh - 60px);
            background-color: #FFF;
            border-right: 1px solid #DDD;
            padding-top: 20px;
            z-index: 1000;
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
        /* Основной контент – все секции имеют общий стиль */
        .main-content {
            margin-left: 200px;
            padding: 20px;
            /*padding-top: 80px;*/
            background-color: #F5F5F5;
            min-height: calc(100vh - 60px);
            display: none; /* Все секции по умолчанию скрыты */
        }
        .main-content.active {
            display: block;
        }
        .main-content h2 {
            margin-bottom: 20px;
            color: #4A4A4A;
            font-size: 1.5rem;
        }
        /* Таблицы */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #DDD;
            text-align: left;
        }
        .table th {
            background-color: #F9F9F9;
        }
        /* Бейджи для статусов */
        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .bg-primary {
            background-color: #007bff;
            color: #fff;
        }
        .bg-success {
            background-color: #28a745;
            color: #fff;
        }
        .bg-secondary {
            background-color: #6c757d;
            color: #fff;
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
        /* Модальное окно */
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
            text-align: center;
        }
        .modal-content label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .modal-content input,
        .modal-content select,
        .modal-content textarea {
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

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>{{ __('messages.news') }}</span>
        </div>
        <a class="sidebar-item" onclick="showPersonal()">
            <i class="fas fa-user"></i>
            <span>{{ __('messages.personal_data') }}</span>
        </a>
        <div class="sidebar-item" onclick="showRequests()">
            <i class="fas fa-wrench"></i>
            <span>{{ __('messages.requests') }}</span>
        </div>
    </div>

    <!-- ===== SECTION: Новости ===== -->
    <div class="main-content" id="news-section">
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
                        <div class="personal-location">
                            @if(Auth::user()->acceptedBooking)
                                {{ __('messages.building') }}: {{ Auth::user()->acceptedBooking->building->name }}<br>
                                {{ __('messages.address') }}: {{ Auth::user()->acceptedBooking->building->address }}<br>
                                {{ __('messages.floor') }}: {{ Auth::user()->acceptedBooking->room->floor }}<br>
                                {{ __('messages.room') }}: {{ Auth::user()->acceptedBooking->room->room_number }}
                            @else
                                <p>{{ __('messages.not_assigned') }}</p>
                            @endif
                        </div>
                        <form class="personal-form" action="{{ route('employee.updateProfile') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="job_type">{{ __('messages.job_type') }}</label>
                                <input type="text" name="job_type" value="{{ old('job_type', Auth::user()->employee->job_type ?? 'Не выбран') }}">
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
                            <div>
                                <label>{{ __('messages.photo') }}</label>
                                <input type="file" name="photo">
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
    <!-- ===== МОДАЛЬНОЕ ОКНО: Смена пароля ===== -->
    <div class="modal-overlay" id="passwordModal">
        <div class="modal-content">
            <button class="close-button" onclick="closePasswordModal()">&times;</button>
            <h2>{{ __('messages.change_password') }}</h2>
            @if(session('password_success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px;">
                    {{ session('password_success') }}
                </div>
            @endif
            <form action="{{ route('employee.updatePassword') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="current_password">{{ __('messages.current_password') }}</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">{{ __('messages.new_password') }}</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">{{ __('messages.confirm_new_password') }}</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-success">{{ __('messages.update') }}</button>
            </form>
        </div>
    </div>
    <!-- ===== SECTION: Список заявок ===== -->
    <div class="main-content" id="request-section">
        <div class="container">
            <h2>{{ __('messages.all_requests') }}</h2>
            <a class="btn btn-outline-secondary" href="{{ route('employee.dashboard') }}">{{ __('messages.back') }}</a>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">{{ __('messages.requests') }}</h5>
            </div>
            <button class="btn btn-outline-secondary btn-sm mb-3">{{ __('messages.select_period') }}</button>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>{{ __('messages.request') }}</th>
                        <th>{{ __('messages.date') }}</th>
                        <th>{{ __('messages.employee') }}</th>
                        <th>{{ __('messages.status') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($repairRequests as $req)
                        <tr>
                            <td>{{ $req->id }}</td>
                            <td>
                                <a href="javascript:void(0)" class="text-primary text-decoration-none"
                                   onclick="viewRequestDetails({{ $req->id }})">
                                    {{ $req->type }}
                                </a>
                            </td>
                            <td>{{ $req->created_at }}</td>
                            <td>{{ $req->employee->name ?? __('messages.not_assigned') }}</td>
                            <td>
                                @if($req->status == 'pending')
                                    <span class="badge bg-warning text-dark">{{ __('messages.in_review') }}</span>
                                @elseif($req->status == 'accepted')
                                    <span class="badge bg-primary">{{ __('messages.accept') }}</span>
                                @elseif($req->status == 'done')
                                    <span class="badge bg-success">{{ __('messages.completed') }}</span>
                                @elseif($req->status == 'In review')
                                        <span class="badge bg-warning text-dark">{{ __('messages.in_review') }}</span>
                                @elseif($req->status == 'Accept')
                                        <span class="badge bg-primary">{{ __('messages.accept') }}</span>
                                @elseif($req->status == 'Completed')
                                        <span class="badge bg-success">{{ __('messages.completed') }}</span>
                                @elseif($req->status == 'Қарастырылуда')
                                    <span class="badge bg-warning text-dark">{{ __('messages.in_review') }}</span>
                                @elseif($req->status == 'Қабылдау')
                                    <span class="badge bg-primary">{{ __('messages.accept') }}</span>
                                @elseif($req->status == 'Орындалды')
                                    <span class="badge bg-success">{{ __('messages.completed') }}</span>
{{--                                @else--}}
{{--                                    <span class="badge bg-secondary">{{ __('messages.unknown') }}</span>--}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ===== SECTION: Детали заявки ===== -->
    <div class="main-content request-details-section" id="request-details-section">
        <div class="container">
            <h2>{{ __('messages.request_details') }} #<span id="req-id"></span></h2>
            <div class="d-flex mb-3">
                <a href="javascript:void(0)" class="btn btn-secondary me-2" onclick="showRequests()">{{ __('messages.back') }}</a>
                <a href="javascript:void(0)" class="btn btn-primary me-2" onclick="openEditRequest()">{{ __('messages.change_status') }}</a>
            </div>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>{{ __('messages.request') }}</th>
                    <th>{{ __('messages.description') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.employee') }}</th>
                    <th>{{ __('messages.status') }}</th>
                </tr>
                </thead>
                <tbody id="req-details-body">
                <!-- Заполняется через JS -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- ===== SECTION: Редактирование заявки ===== -->
    <div class="main-content edit-request-section" id="edit-request-section">
        <div class="container">
            <h2>{{ __('messages.edit_request') }} #<span id="edit-req-id"></span></h2>
            <a href="javascript:void(0)" class="btn btn-secondary mb-3" onclick="showRequestDetails()">{{ __('messages.back') }}</a>
            <div class="card">
                <div class="card-body">
                    <form id="editRequestForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit-type" class="form-label">{{ __('messages.request_type') }}</label>
                            <input type="text" id="edit-type" name="type" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">{{ __('messages.description') }}</label>
                            <textarea id="edit-description" name="description" class="form-control" rows="3" required readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-status" class="form-label">{{ __('messages.status') }}:</label>
                            <select name="status" id="edit-status" class="form-control">
                                <option value="pending">{{ __('messages.in_review') }}</option>
                                <option value="accepted">{{ __('messages.accept') }}</option>
                                <option value="done">{{ __('messages.completed') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">{{ __('messages.save_changes') }}</button>
                        <a href="javascript:void(0)" class="btn btn-danger" onclick="showRequestDetails()">{{ __('messages.cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNews();
            @if(session('successType') === 'view_requests')
            showRequests();
            @elseif(session('successType') === 'show_requests')
            showRequestDetails();
            @elseif(session('successType') === 'profile_updated')
            showPersonal()
            @elseif(session('successType') === 'request_updated')
            openEditRequest()
            @endif
        });
        function hideAllSections() {
            document.querySelectorAll('.main-content').forEach(section => {
                section.classList.remove('active');
            });
        }
        function showNews() {
            hideAllSections();
            document.getElementById('news-section').classList.add('active');
        }
        function showPersonal() {
            hideAllSections();
            document.getElementById('personal-section').classList.add('active');
        }
        function showRequests() {
            hideAllSections();
            document.getElementById('request-section').classList.add('active');
        }
        function showRequestDetails() {
            hideAllSections();
            document.getElementById('request-details-section').classList.add('active');
        }
        function openEditRequest() {
            hideAllSections();
            document.getElementById('edit-request-section').classList.add('active');
            // Если данные выбранного запроса уже сохранены в глобальной переменной window.currentRequest, заполняем форму
            if (window.currentRequest) {
                document.getElementById('edit-req-id').textContent = window.currentRequest.id;
                document.getElementById('edit-type').value = window.currentRequest.type;
                document.getElementById('edit-description').value = window.currentRequest.description;
                document.getElementById('edit-status').value = window.currentRequest.status;
                document.getElementById('editRequestForm').action = '/employee/dashboard/requests/' + window.currentRequest.id;
            }
        }
        function viewRequestDetails(reqId) {
            fetch(`/employee/dashboard/requests/${reqId}`)
                .then(response => response.json())
                .then(data => {
                    window.currentRequest = data;

                    const detailsBody = document.getElementById('req-details-body');
                    detailsBody.innerHTML = `<tr>
                <td>${data.id}</td>
                <td>${data.type}</td>
                <td>${data.description}</td>
                <td>${new Date(data.created_at).toLocaleString()}</td>
                <td>${data.employee ? data.employee.name : 'Не назначен'}</td>
                <td><span class="badge ${
                        data.status === 'На рассмотрении' ? 'bg-warning text-dark' :
                            data.status === 'Принято' ? 'bg-primary' :
                                data.status === 'Выполнено' ? 'bg-success' : 'bg-secondary'
                    }">${data.status}</span></td>
            </tr>`;

                    document.getElementById('req-id').textContent = data.id;

                    showRequestDetails();
                })
                .catch(error => {
                    alert('Ошибка при загрузке данных');
                    console.error(error);
                });
        }

        function openPasswordModal() {
            document.getElementById('passwordModal').style.display = 'flex';
        }
        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }
        document.addEventListener('DOMContentLoaded', function () {
            showNews();
        });
    </script>
@endsection
