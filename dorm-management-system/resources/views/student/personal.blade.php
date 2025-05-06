
@extends('layouts.app')
@section('content')
    <style>/* ===== СБРОС СТИЛЕЙ ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }

        /* ===== АВАТАР И ДРОПДАУН МЕНЮ ===== */
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

        /* ===== БОКОВАЯ ПАНЕЛЬ ===== */
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
            cursor: pointer;
            text-decoration: none;
        }
        .sidebar-item:hover {
            background-color: #EFEFEF;
        }
        .sidebar-item i {
            font-size: 18px;
            color: #4A4A4A;
        }

        /* ===== ОСНОВНОЙ КОНТЕНТ ===== */
        .main-content {
            margin-left: 200px;
            padding: 20px;
            padding-top: 80px;
            background-color: #F5F5F5;
            min-height: calc(100vh - 60px);
        }
        .main-content h2 {
            margin-bottom: 20px;
            color: #4A4A4A;
            font-size: 1.5rem;
        }

        /* ===== КАРТОЧКИ, ФОРМЫ, ТАБЛИЦЫ ===== */
        .personal-card,
        .housing-card,
        .sports-form,
        .sports-result {
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .personal-form,
        .sports-form select,
        .sports-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        /* ===== КНОПКИ ===== */
        .btn-primary,
        .btn-secondary,
        .btn-change,
        .btn-finance {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #7e57c2;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #6f42c1;
        }
        .btn-secondary {
            background-color: #ccc;
            color: #333;
        }
        .btn-secondary:hover {
            background-color: #bbb;
        }
        .btn-change {
            background-color: #7e57c2;
            color: #fff;
        }
        .btn-change:hover {
            background-color: #6f42c1;
        }
        .btn-finance {
            background-color: #7e57c2;
            color: #fff;
        }
        .btn-finance:hover {
            background-color: #6f42c1;
        }

        /* ===== ЛИЧНЫЕ ДАННЫЕ, ИНФОРМАЦИЯ ===== */
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

        /* ===== МОДАЛЬНЫЕ ОКНА ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;

        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            width: 500px;
            max-width: 90%;

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

        /* ===== СПОРТИВНАЯ СЕКЦИЯ ===== */
        .sports-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            flex: 1 1 300px;
        }
        .info-item label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .info-item span {
            font-size: 1rem;
            color: #333;
        }
        .edit-link {
            align-self: flex-end;
            color: #007bff;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .edit-link:hover {
            text-decoration: underline;
        }

        /* ===== ОТРАБОТКА (Recovery) ===== */
        .recovery-section {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 20px;
        }
        .recovery-list {
            margin-bottom: 15px;
        }
        .recovery-item {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            margin-bottom: 10px;
        }
        .no-recovery {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ===== ПРОЧИЕ СТИЛИ ===== */
        .container {
            width: 900px;
        }
        .btn-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #3b82f6;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
            width: 220px;
            text-align: center;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-nav:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }

        /* Стили для формы загрузки документа (uploadForm) */
        #uploadForm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        /* ===== ФИНАНСОВЫЙ РАЗДЕЛ ===== */
        .finance-dashboard {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .finance-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .balance-card {
            background: linear-gradient(135deg, #7e57c2 0%, #6f42c1 100%);
            color: white;
        }

        .balance-amount {
            font-size: 2.5em;
            font-weight: bold;
            margin: 15px 0;
        }

        .payment-history-card {
            grid-column: 1 / -1;
        }

        .payment-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .payment-form input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }

        .payment-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
        }

        .kaspi-button {
            background-color: #7e57c2;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .kaspi-button:hover {
            background-color: #6f42c1;
        }

        .kaspi-button:disabled {
            background-color: #b39ddb;
            cursor: not-allowed;
        }
    </style>
{{--     ЛЕВАЯ ПАНЕЛЬ--}}
    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>{{__('messages.main')}}</span>
        </div>
        <div class="sidebar-item" onclick="showPersonal()">
            <i class="fas fa-user"></i>
            <span>{{__('messages.personal_information')}}</span>
        </div>
        @if(Auth::user()->bookings->where('status', 'accepted')->isNotEmpty())
        <div class="sidebar-item" onclick="showHousing()">
            <i class="fas fa-building"></i>
            <span>{{__('messages.accommodation')}}</span>
        </div>
        <div class="sidebar-item" onclick="showDocuments()">
            <i class="fa-solid fa-clipboard"></i>
            <span>{{__('messages.documents')}}</span>
        </div>
        <div class="sidebar-item" onclick="showFinance()">
            <i class="fas fa-wallet"></i>
            <span>{{__('messages.financial_cabinet')}}</span>
        </div>
        <div class="sidebar-item" onclick = "showRequestRepair()">
            <i class="fas fa-wrench"></i>
            <span>{{__('messages.repair_requests')}}</span>
        </div>
        @endif
        <div class="sidebar-item" onclick="showSportsBooking()">
            <i class="fas fa-dumbbell"></i>
            <span>{{__('messages.registration_for_physical_edu')}}</span>
        </div>
    </div>
    <!-- Личная информация -->
    <div class="main-content" id="personal-section" style="display: none;">
        <h2>{{ __('messages.personal_data') }}</h2>
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
                    <!-- Пример локации -->
                    <div class="personal-location">
                        @if(Auth::user()->acceptedBooking)
                            {{ __('messages.building') }}: {{ Auth::user()->acceptedBooking->building->name }}<br>
                            {{ __('messages.address') }}: {{ Auth::user()->acceptedBooking->building->address }}<br>
                            {{ __('messages.floor') }}: {{ Auth::user()->acceptedBooking->room->floor }}<br>
                            {{ __('messages.room') }}: {{ Auth::user()->acceptedBooking->room->room_number }}
                        @else
                            <p>{{ __('messages.not_settled') }}</p>
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
                            <label>{{ __('messages.phone_number') }}</label>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                        </div>
                        <div>
                            <label>{{ __('messages.email') }}</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div>
                            <label>{{ __('messages.password') }}</label>
                            <!-- Вместо реального пароля показываем звездочки -->
                            <div style="display: flex; gap: 10px;">
                                <input type="password" value="********" disabled>
                                <!-- Кнопка, открывающая модальное окно -->
                                <button type="button" class="btn-change" onclick="openPasswordModal()">
                                    {{ __('messages.change') }}
                                </button>
                            </div>
                        </div>
                        <div>
                            <label>{{ __('messages.photo') }}</label>
                            <input type="file" name="photo">
                        </div>
                        <div class="personal-actions">
                            <button type="submit" class="btn-change">{{ __('messages.save') }}</button>
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
            <h2>{{ __('messages.change_password') }}</h2>

            @if(session('password_success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px;">
                    {{ session('password_success') }}
                </div>
            @endif

            <form action="{{ route('student.profile.update') }}" method="POST">
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
                    <label for="new_password_confirmation">{{ __('messages.repeat_new_password') }}</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn-change">{{ __('messages.update') }}</button>
            </form>
        </div>
    </div>
    <!-- Проживание -->
    <div class="main-content" id="housing-section">
        <h2>{{ __('messages.accommodation') }}</h2>
        <div class="housing-card">
            <h3>{{ __('messages.accommodation') }}</h3>
            @if(Auth::user()->acceptedBooking)
                <p class="personal-location">
                    {{ __('messages.building') }}: {{ Auth::user()->acceptedBooking->building->name }},
                    {{ __('messages.address') }}: {{ Auth::user()->acceptedBooking->building->address }},
                    {{ __('messages.floor') }}: {{ Auth::user()->acceptedBooking->room->floor }},
                    {{ __('messages.room') }}: {{ Auth::user()->acceptedBooking->room->room_number }}
                </p>
            @else
                <p>{{ __('messages.not_yet_settled') }}</p>
            @endif
            <button class="btn-finance" onclick="openChangeRoomModal()">{{ __('messages.change_room') }}</button>
            <a href="{{ route('refresh.user') }}" class="btn btn-secondary">{{ __('messages.refresh_data') }}</a>
        </div>
        <div class="housing-card">
            <h3>{{ __('messages.upcoming_payments') }}</h3>
            <button class="btn-finance">{{ __('messages.check_financial_cabinet') }}</button>
        </div>
    </div>
    <!-- Модальное окно для смены комнаты -->
    <div class="modal-overlay" id="changeRoomModal" style="display: none;">
        <div class="modal-content">
            <button class="close-button" onclick="closeChangeRoomModal()">&times;</button>
            <h2>{{ __('messages.room_change_request') }}</h2>

            <!-- Форма для смены комнаты -->
            <form action="{{ route('booking.changeRoom') }}" method="POST">
                @csrf
                <label for="buildingSelect">{{ __('messages.building') }}:</label>
                <select id="buildingSelect" name="building_id">
                    <option value="">{{ __('messages.select_building') }}</option>
                    @foreach($buildings as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>

                <label for="floorSelect">{{ __('messages.floor') }}:</label>
                <select id="floorSelect" name="floor" disabled>
                    <option value="">{{ __('messages.select_building_first') }}</option>
                </select>

                <label for="roomSelect">{{ __('messages.room') }}:</label>
                <select id="roomSelect" name="room_id" disabled>
                    <option value="">{{ __('messages.select_floor_first') }}</option>
                </select>

                <button type="submit" class="btn-change">{{ __('messages.submit_request') }}</button>
            </form>
        </div>
    </div>
    <!-- Документы -->
    <div id="documents-section" class="main-content" style="display: none;">
        <h2>{{ __('messages.documents') }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.type') }}</th>
                    <th>{{ __('messages.file') }}</th>
                    <th>{{ __('messages.valid_until') }}</th>
                    <th>{{ __('messages.status') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td>{{ $doc->id }}</td>
                        <td><a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ $doc->file_name }}</a></td>
                        <td>{{ $doc->created_at->format('d.m.Y') }}</td>
                        <td>—</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">{{ __('messages.no_documents_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <button id="uploadButton" class="btn btn-primary mt-3">{{ __('messages.upload_new') }}</button>
    </div>
    <div id="financeSection" class="main-content" style="display: none;">
        <h2>Финансовый кабинет</h2>

        <div class="finance-dashboard">
            <!-- Карточка баланса -->
            <div class="finance-card balance-card">
                <h3>Текущий баланс</h3>
                <div class="balance-amount">{{ number_format($balance ?? 0, 0, ',', ' ') }} ₸</div>
                <p>Последнее обновление: {{ now()->format('d.m.Y H:i') }}</p>
            </div>
            <div class="finance-card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; ">
                <div class="qr-container" style="text-align: center; width: 100%; max-width: 300px;">
                    <h3 style="margin-bottom: 20px;">Оплата через Kaspi</h3>
                    <img src="{{ asset('storage/images/kaspi-qr.jpg') }}"
                         alt="Kaspi QR"
                         style="width: 70%; height: auto; border: 1px solid #ddd; border-radius: 4px; display: block; margin: 0 auto;">
                    <p style="margin-top: 15px; color: #666;">Отсканируйте QR-код для оплаты через Kaspi</p>
                </div>
            </div>

            <!-- Карточка оплаты -->
            <div class="finance-card">
                <h3>Тестовая оплата</h3>
                <div class="alert alert-info">
                    Тестовый режим: реальные платежи не проводятся
                </div>
                <form id="kaspiPaymentForm" class="mt-4">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Сумма оплаты (₸)</label>
                        <input type="number"
                               id="amount"
                               name="amount"
                               min="100"
                               step="100"
                               required
                               class="form-control"
                               placeholder="Введите сумму">
                    </div>
                    <button type="submit" class="btn-finance mt-3">
                        <i class="fas fa-credit-card"></i> Тестовая оплата
                    </button>
                </form>
            </div>
            <!-- История платежей -->
            <div class="finance-card payment-history-card">
                <h3>История платежей</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Способ оплаты</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments ?? [] as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ number_format($payment->amount, 0, ',', ' ') }} ₸</td>
                            <td>
                            <span class="payment-status status-{{ $payment->status }}">
                                {{ __('messages.payment_status_' . $payment->status) }}
                            </span>
                            </td>
                            <td>{{ $payment->payment_method }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Форма загрузки документа (скрыта по умолчанию) -->
    <div id="uploadForm" style="display: none; margin-top: 20px;">
        <form action="{{ route('document.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <label for="documentFile" class="form-label">{{ __('messages.select_file') }}:</label>
                <input type="file" name="documentFile" id="documentFile" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">{{ __('messages.upload') }}</button>
            <button type="button" id="cancelUpload" class="btn btn-secondary">{{ __('messages.cancel') }}</button>
        </form>
    </div>
    <!-- Запросы на ремонт -->
    <div class="flex space-x-6 items-start main-content" id="repair-list" style="display: none;">
        <div class="row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><strong>{{ __('messages.create_repair_request') }}</strong></h2>
                        <p class="card-text">{{ __('messages.repair_description') }}</p>
                        <!-- Кнопка, вызывающая JS-функцию открытия модального окна -->
                        <button type="button" class="btn btn-primary mt-3" onclick="openRepairModal()">{{ __('messages.create_request') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><strong>{{ __('messages.my_requests') }}</strong></h2>
                        <p class="card-text">{{ __('messages.view_requests_description') }}</p>
                        <!-- При клике показываем блок со списком запросов -->
                        <button type="button" class="btn btn-primary mt-3" onclick="openRequestList()">{{ __('messages.view_requests') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Модальное окно для создания запроса на ремонт -->
    <div id="repairModal" class="modal-overlay">
        <div class="modal-content">
            <!-- Кнопка закрытия модального окна -->
            <button class="close-button absolute top-2 right-2 text-xl" onclick="closeRepairModal()">&times;</button>
            <h2 class="text-lg font-semibold text-gray-800 text-center">{{ __('messages.new_repair_request') }}</h2>
            <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-4">
                    <label class="block text-sm text-gray-600">{{ __('messages.problem_type') }}</label>
                    <select name="type" id="type" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option selected disabled>{{ __('messages.select_problem') }}</option>
                        <option value="Электрика">{{ __('messages.electricity') }}</option>
                        <option value="Водопровод">{{ __('messages.plumbing') }}</option>
                        <option value="Другое">{{ __('messages.other') }}</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block text-sm text-gray-600">{{ __('messages.problem_description') }}</label>
                    <textarea class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" rows="3" placeholder="{{ __('messages.enter_description') }}" name="description"></textarea>
                </div>

                <div class="mt-4">
                    <input type="file" id="file-upload" class="hidden" name="file">
                    <label for="file-upload" id="file-label" class="text-sm text-gray-500 cursor-pointer block border-dashed border-2 p-2 rounded-lg text-center">
                        📎 {{ __('messages.attach_file') }} ({{ __('messages.not_selected') }})
                    </label>
                </div>

                <div class="mt-4">
                    <label class="block text-sm text-gray-600">{{ __('messages.select_employee') }}</label>
                    <select class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="employee">
                        <option selected disabled>{{ __('messages.select_employee_problem') }}</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="submit" class="bg-green-300 text-gray-800 px-4 py-2 hover:bg-green-400 rounded">{{ __('messages.submit') }}</button>
                    <button type="button" onclick="closeRepairModal()" class="bg-gray-300 text-gray-800 px-4 py-2 hover:bg-gray-400 rounded">{{ __('messages.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Блок со списком запросов -->
    <div class="container mt-5 main-content" id="request-list" style="display: none;">
        <div class="card shadow-sm">
            <div class="card-body">
                <a href="javascript:void(0)" onclick="closeRequestList()">{{ __('messages.back') }}</a>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title">{{ __('messages.all_requests') }}</h5>
                    <!-- Можно оставить кнопку для создания запроса -->
                    <button type="button" class="btn btn-primary btn-sm" onclick="openRepairModal()">➕</button>
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
                        @foreach($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>
                                    <!-- При клике передаём id запроса -->
                                    <a href="javascript:void(0)" class="request-link text-primary text-decoration-none"
                                       onclick="openRequestDetails({{ $request->id }})">
                                        {{ $request->type }}
                                    </a>
                                </td>
                                <td>{{ $request->created_at }}</td>
                                <td>{{ $request->employee->name ?? __('messages.not_assigned') }}</td>
                                <td>
                                    <span class="badge bg-success">{{__('status.' . $request->status)}}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Детали запросов-->
    @foreach($requests as $request)
        <div id="request-details-{{ $request->id }}" class="request-details" style="display: none;">
            <div class="container">
                <h2 class="mb-4 mt-5">{{__('messages.details_request')}} #{{ $request->id }}</h2>

                <!-- Кнопки действий -->
                <div class="d-flex mb-3">
                    <button class="btn btn-secondary me-2" onclick="closeRequestDetails({{ $request->id }})">{{__('messages.back')}}</button>
                    <button type="button" class="btn btn-primary me-2" onclick="openEditModal({{ $request->id }})">{{__('messages.edit')}}</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $request->id }}">
                        {{__('messages.delete')}}
                    </button>
                </div>

                <!-- Таблица с деталями запроса -->
                <table class="table table-bordered align-middle mb-4">
                    <thead class="table-light">
                    <tr>
                        <th>{{__('messages.number')}}</th>
                        <th>{{__('messages.request')}}</th>
                        <th>{{__('messages.details')}}</th>
                        <th>{{__('messages.date')}}</th>
                        <th>{{__('messages.employee')}}</th>
                        <th>{{__('messages.status')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->type }}</td>
                        <td>{{ $request->description }}</td>
                        <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $request->employee->name ?? __('messages.not_assigned') }}</td>
                        <td><span class="badge bg-success">{{ $request->status }}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Модальное окно для подтверждения удаления запроса -->
            <div class="modal fade" id="deleteModal-{{ $request->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $request->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel-{{ $request->id }}">{{__('messages.delete_request')}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{__('messages.close')}}"></button>
                        </div>
                        <div class="modal-body">
                            {{__('messages.are_you_sure_delete')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('messages.cancel')}}</button>
                            <form action="{{ route('request.destroy', $request->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">{{__('messages.delete')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Модальное окно для редактирования запроса (скрыто по умолчанию) -->
    @foreach($requests as $request)
        <div class="modal-overlay" id="edit-modal-{{ $request->id }}" style="display: none; justify-content: center; align-items: center;">
            <div class="modal-content bg-white shadow-xl rounded-2xl p-6 w-96 relative">
                <button class="close-button absolute top-2 right-2 text-xl" onclick="closeEditModal({{ $request->id }})">&times;</button>
                <h2 class="mb-4 mt-5">{{__('messages.edit_request')}} #{{ $request->id }}</h2>
                <a href="javascript:void(0)" onclick="closeEditModal({{ $request->id }})" class="btn btn-secondary mb-3">{{__('messages.back')}}</a>
                <!-- Форма редактирования -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('request.update', $request->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Тип запроса -->
                            <div class="mb-3">
                                <label for="type-{{ $request->id }}" class="form-label">{{__('messages.request_type')}}</label>
                                <input type="text" id="type-{{ $request->id }}" name="type" class="form-control" value="{{ $request->type }}" required>
                            </div>
                            <!-- Описание -->
                            <div class="mb-3">
                                <label for="description-{{ $request->id }}" class="form-label">{{__('messages.description')}}</label>
                                <textarea id="description-{{ $request->id }}" name="description" class="form-control" rows="3" required>{{ $request->description }}</textarea>
                            </div>
                            <!-- Сотрудник -->
                            <div class="mb-3">
                                <label for="employee_id-{{ $request->id }}" class="form-label">{{__('messages.employee')}}</label>
                                <select id="employee_id-{{ $request->id }}" name="employee_id" class="form-control">
                                    <option value="">{{__('messages.not_assigned')}}</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ $request->employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Кнопки действий -->
                            <button type="submit" class="btn btn-success">{{__('messages.save_changes')}}</button>
                            <button type="button" class="btn btn-danger" onclick="closeEditModal({{ $request->id }})">{{__('messages.cancel')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Запись на занятия физкультурой -->
    <div class="main-content" id="sports-section" style="display: none;">
        <h2>{{__('messages.sports_booking')}}</h2>
        @if($booking)
            <!-- ВАРИАНТ 2: Пользователь уже записан -->
            <div class="sports-result" id="sportsResultBlock">
                <h3>{{__('messages.already_booked')}}</h3>
                <div class="sports-info">
                    <div class="info-item">
                        <label>{{__('messages.sport_type')}}:</label>
                        <span>{{ $booking->sport }}</span>
                    </div>
                    <div class="info-item">
                        <label>{{__('messages.day_time')}}:</label>
                        <span>{{ $booking->day }} {{ $booking->scheduled_time }}</span>
                    </div>
                    <!-- Форма для отмены записи на занятие -->
                    <form action="{{ route('sports.cancel') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-change">{{__('messages.cancel_booking')}}</button>
                    </form>
                </div>

                <!-- Блок отработки -->
                <div class="recovery-section">
                    <h4>{{__('messages.recovery_section')}}</h4>
                    @if($recoveries->count() > 0)
                        <div class="recovery-list">
                            @foreach($recoveries as $recovery)
                                <div class="recovery-item">
                                    <div class="info-item">
                                        <label>{{__('messages.sport_type')}}:</label>
                                        <span>{{ $recovery->sport }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>{{__('messages.time')}}:</label>
                                        <span>{{ $recovery->scheduled_time }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>{{__('messages.date')}}:</label>
                                        <span>{{ $recovery->created_at->format('d.m.Y') }}</span>
                                    </div>
                                    <!-- Форма для отмены отработки -->
                                    <form action="{{ route('sports.recovery.cancel', $recovery->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-change">{{__('messages.cancel_recovery')}}</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>{{__('messages.no_scheduled_recovery')}}</p>
                    @endif
                    <!-- Кнопка для открытия модального окна добавления новой отработки -->
                    <button onclick="showRecoveryModal()" class="btn-change">+</button>
                </div>
            </div>
        @else
            <!-- ВАРИАНТ 1: Форма записи -->
            <div class="sports-form" id="sportsFormBlock">
                <h3>{{__('messages.sports_booking')}}</h3>
                <form id="sportsForm" action="{{ route('sports.store') }}" method="POST">
                    @csrf

                    <label for="sport">{{__('messages.sport_type')}}</label>
                    <select name="sport" id="sport" required>
                        <option value="">{{__('messages.choose')}}</option>
                        <option value="Танцы">{{__('messages.dance')}}</option>
                        <option value="Баскетбол">{{__('messages.basketball')}}</option>
                        <option value="Волейбол">{{__('messages.volleyball')}}</option>
                        <option value="Футбол">{{__('messages.football')}}</option>
                    </select>

                    <!-- Блок выбора дней недели -->
                    <label>{{__('messages.select_days')}}</label>
                    <div id="day-selection">
                        <label><input type="checkbox" name="day[]" value="Понедельник">{{__('messages.monday')}}</label>
                        <label><input type="checkbox" name="day[]" value="Вторник">{{__('messages.tuesday')}}</label>
                        <label><input type="checkbox" name="day[]" value="Среда">{{__('messages.wednesday')}}</label>
                        <label><input type="checkbox" name="day[]" value="Четверг">{{__('messages.thursday')}}</label>
                        <label><input type="checkbox" name="day[]" value="Пятница">{{__('messages.friday')}}</label>
                        <label><input type="checkbox" name="day[]" value="Суббота">{{__('messages.saturday')}}</label>
                        <label><input type="checkbox" name="day[]" value="Воскресенье">{{__('messages.sunday')}}</label>
                    </div>

                    <label for="time">{{__('messages.select_time')}}</label>
                    <input type="time" name="time" id="time" required>

                    <div class="checkbox-group">
                        <input type="checkbox" id="autoEnroll">
                        <label for="autoEnroll">{{__('messages.auto_enroll')}}</label>
                    </div>

                    <button type="submit" class="btn-primary">{{__('messages.book_now')}}</button>
                    <button type="button" class="btn-secondary" onclick="cancelSportsForm()">{{__('messages.cancel')}}</button>
                </form>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNews();
            @if(session('successType') === 'profile_updated')
            showPersonal();
            @elseif(session('successType') === 'request_updated')
            openRequestList();
            @elseif(session('successType') === 'request_created')
            openRequestList();
            @elseif(session('successType') === 'gym_created')
            showSportsBooking();
            @elseif(session('successType') === 'gym_canceled')
            showSportsBooking();
            @elseif(session('successType') === 'recovery_created')
            showSportsBooking();
            @elseif(session('successType') === 'recovery_canceled')
            showSportsBooking();
            @elseif(session('successType') === 'change_room_created')
            showHousing();
            @elseif(session('successType') === 'user_updated')
            showHousing()
            @elseif(session('successType') === 'document_uploaded')
            showDocuments();
            @endif
        });
        function showPersonal() {
            hideAllSections()
            document.getElementById('personal-section').style.display = 'block';
        }
        function openPasswordModal() {
            document.getElementById('passwordModal').style.display = 'flex';
        }
        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }
        function showHousing() {
            hideAllSections()
            document.getElementById('housing-section').style.display = 'block';
        }
        function openChangeRoomModal() {
            document.getElementById('changeRoomModal').style.display = 'flex';
        }
        function closeChangeRoomModal() {
            document.getElementById('changeRoomModal').style.display = 'none';
        }
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

                const response = await fetch(`/student/personal/floors/${buildingId}`);
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

                const response = await fetch(`/student/personal/rooms/${buildingId}/${floor}`);
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
            console.log("DOM полностью загружен");
        });
        function showDocuments() {
            hideAllSections();
            document.getElementById('documents-section').style.display = 'block';
        }

        // Добавьте функцию показа финансового раздела
        function showFinance() {
            hideAllSections();
            document.getElementById('financeSection').style.display = 'block';
        }

        document.getElementById('kaspiPaymentForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            try {
                const response = await fetch('/student/payment/initiate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        amount: document.getElementById('amount').value
                    })
                });

                const result = await response.json();

                if (result.success && result.payment_url) {
                    window.location.href = result.payment_url;
                } else {
                    alert(result.message || 'Ошибка при создании платежа');
                }
            } catch (error) {
                console.error('Payment error:', error);
                alert('Произошла ошибка при обработке платежа');
            }
        });

        document.getElementById('uploadButton').addEventListener('click', function () {
            document.getElementById('uploadForm').style.display = 'block';
        });
        document.getElementById('cancelUpload').addEventListener('click', function () {
            document.getElementById('uploadForm').style.display = 'none';
        });
        function showRequestRepair() {
            hideAllSections();
            document.getElementById('repair-list').style.display = 'block';
        }
        function openRequestDetails(id) {
            hideAllSections();
            document.getElementById('request-details-' + id).style.display = 'block';
        }
        function closeRequestDetails(id) {
            document.getElementById('request-details-' + id).style.display = 'none';
            document.getElementById('request-list').style.display = 'block';
        }
        function openRequestList() {
            hideAllSections();
            document.getElementById('request-list').style.display = 'block';
        }
        function closeRequestList() {
            document.getElementById('request-list').style.display = 'none';
            document.getElementById('repair-list').style.display = 'block';
        }
        function openRepairModal() {
            document.getElementById('repairModal').style.display = 'flex';
        }
        function closeRepairModal() {
            document.getElementById('repairModal').style.display = 'none';
        }
        function openEditModal(id) {
            document.getElementById('edit-modal-' + id).style.display = 'flex';
        }
        function closeEditModal(id) {
            document.getElementById('edit-modal-' + id).style.display = 'none';
        }
        document.getElementById("file-upload").addEventListener("change", function () {
            let fileName = this.files[0] ? this.files[0].name : "Не выбрано";
            document.getElementById("file-label").textContent = `📎 ${fileName}`;
        });
        function showSportsBooking() {
            hideAllSections();
            document.getElementById('sports-section').style.display = 'block';
        }
        function cancelSportsForm() {
            document.getElementById('sport').value = '';
            document.getElementById('time').value = '';
            // Сбросить выбранные дни недели
            const checkboxes = document.querySelectorAll('#day-selection input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = false);
        }
        function showRecoveryModal() {
            document.getElementById('recoveryModal').style.display = 'flex';
        }
        function closeRecoveryModal() {
            document.getElementById('recoveryModal').style.display = 'none';
        }
        function hideAllSections() {
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('personal-section').style.display = 'none';
            document.getElementById('housing-section').style.display = 'none';
            document.getElementById('documents-section').style.display='none';
            document.getElementById('financeSection').style.display = 'none';
            document.getElementById('repair-list').style.display = 'none';
            document.getElementById('request-list').style.display = 'none';
            document.getElementById('repairModal').style.display = 'none';
            document.getElementById('sports-section').style.display = 'none';
            @foreach($requests as $request)
            document.getElementById('edit-modal-{{ $request->id }}').style.display = 'none';
            @endforeach
        }
    </script>
@endsection
