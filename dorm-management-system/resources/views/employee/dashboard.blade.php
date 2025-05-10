@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/employeeDashboard.css') }}" rel="stylesheet">

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>{{ __('messages.main') }}</span>
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">{{ __('messages.requests') }}</h5>
            </div>
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
                                    <p class="btn btn-secondary">{{__('status.' . $req->status)}}</p>
                                    @elseif($req->status == 'done')
                                        <p class="btn btn-success">{{__('status.' . $req->status)}}</p>
                                        @elseif($req->status == 'accepted')
                                            <p class="btn btn-primary">{{__('status.' . $req->status)}}</p>
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
        window.statusTranslations = {
            pending: "{{ __('status.pending') }}",
            accepted: "{{ __('status.accepted') }}",
            done: "{{ __('status.done') }}"
        };
        document.addEventListener('DOMContentLoaded', function() {
            showNews();
            @if(session('successType') === 'view_requests')
            showRequests();
            @elseif(session('successType') === 'show_requests')
            showRequestDetails();
            @elseif(session('successType') === 'profile_updated')
            showPersonal()
            @elseif(session('successType') === 'request_updated')
            showRequests();
            @endif
        });
        function hideAllSections() {
            document.querySelectorAll('.main-content').forEach(section => {
                section.style.display = 'none';
            });
        }
        function showPersonal() {
            hideAllSections();
            document.getElementById('personal-section').style.display = 'block';
        }

        function showRequests() {
            hideAllSections();
            document.getElementById('request-section').style.display = 'block';

        }
        function showRequestDetails() {
            hideAllSections();
            document.getElementById('request-details-section').style.display = 'block';

        }
        function openEditRequest() {
            hideAllSections();
            document.getElementById('edit-request-section').style.display = 'block';

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

                    // Найти перевод статуса
                    const translatedStatus = window.statusTranslations[data.status] || data.status;

                    detailsBody.innerHTML = `<tr>
                <td>${data.id}</td>
                <td>${data.type}</td>
                <td>${data.description}</td>
                <td>${new Date(data.created_at).toLocaleString()}</td>
                <td>${data.employee ? data.employee.name : '{{ __("messages.not_assigned") }}'}</td>
                <td>${translatedStatus}</td>
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

    </script>
@endsection
