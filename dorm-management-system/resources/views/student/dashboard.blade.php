@extends('layouts.app')

@section('content')
    <style>
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 200px;
            height: calc(100vh - 60px);
            background-color: #fff;
            border-right: 1px solid #ddd;
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
            background-color: #efefef;
            cursor: pointer;
        }
        .sidebar-item i {
            font-size: 18px;
            color: #4a4a4a;
        }

        /* Main Content */
        .main-content {
            margin-left: 200px;
            padding: 80px 20px 20px;
        }
        .main-content h2 {
            margin-bottom: 20px;
            color: #4a4a4a;
        }

        /* Avatar Circle */
        .avatar-circle-big {
            width: 45px;
            height: 45px;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 11px;
        }

        /* Logout */
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

        /* Application Form */
        .housing-form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        .housing-form select,
        .housing-form button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .application-container {
            margin-left: 280px;
            margin-top: 50px;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .application-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .application-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4a4a4a;
        }
        .application-box select,
        .application-box button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .application-box button {
            background: #7e57c2;
            color: white;
            border: none;
            cursor: pointer;
        }
        .application-box button:hover {
            background: #6f42c1;
        }

        #housing-sidebar {
            display: none;
        }
        #housing-sidebar.open {
            display: block;
        }
    </style>

    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>{{__('messages.main')}}</span>
        </div>
        @if(Auth::check() && Auth::user()->role === 'student' && optional(Auth::user()->student)->room_id == null)
            <div class="sidebar-item" onclick="showHousing()">
                <i class="fas fa-bed"></i>
                <span>{{ __('messages.housing_application') }}</span>
            </div>
        @endif
        <div class="sidebar-item" onclick="showMarketplace()">
            <i class="fas fa-store"></i>
            <span>{{ __('messages.marketplace') }}</span>
        </div>
    </div>


    <div class="application-container" id="housing-sidebar">
        <div class="application-box">
            <h2>{{ __('messages.housing_application') }}</h2>
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <label for="building">{{ __('messages.select_building') }}:</label>
                <select name="building_id" id="building">
                    <option value="">{{ __('messages.select_building') }}</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                    @endforeach
                </select>

                <label for="floor">{{ __('messages.select_floor') }}:</label>
                <select name="floor" id="floor" disabled>
                    <option value="">{{ __('messages.choose_building_first') }}</option>
                </select>

                <label for="room">{{ __('messages.select_room') }}:</label>
                <select name="room_id" id="room" disabled>
                    <option value="">{{ __('messages.choose_floor_first') }}</option>
                </select>
                <button type="submit">{{ __('messages.apply') }}</button>
            </form>
        </div>
    </div>

    {{-- Купи‑продай секция --}}
    <div class="application-container" id="marketplace-section" style="display: none;">
        {{-- Фильтры --}}
        <form method="GET" action="{{ route('student.dashboard') }}" class="mb-4">
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск товара..." class="form-control" />

                <select name="category_id" class="form-control">
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="sort" class="form-control">
                    <option value="">Сортировать по цене</option>
                    <option value="price_asc"  {{ request('sort')=='price_asc'  ? 'selected':'' }}>От дешёвых к дорогим</option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected':'' }}>От дорогих к дешёвым</option>
                </select>

                <button type="submit" class="btn btn-primary">Применить фильтр</button>
            </div>
        </form>

        {{-- Заголовок и кнопки --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>🛍️ Купи‑продай</h2>
            <div style="display: flex; gap: 8px;">
                <button class="btn btn-primary" onclick="openCreateAdModal()">+ Разместить</button>
                <button class="btn btn-secondary" onclick="toggleMyAds()">Посмотреть ваши объявления</button>
            </div>
        </div>

        {{-- Все объявления --}}
        <div id="all-ads" class="ads-grid">
            @foreach($ads as $ad)
                <div class="ad-card">
                    @if($ad->image)
                        <img src="{{ asset('storage/' . $ad->image) }}" alt="" />
                    @endif
                    <div class="content">
                        <div class="title">{{ $ad->title }}</div>
                        <div class="description">{{ Str::limit($ad->description, 100) }}</div>
                        <div class="meta">Цена: {{ $ad->price }} тг • {{ \App\Http\Controllers\AdController::getCategories()[$ad->category] ?? $ad->category }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Только ваши объявления --}}
        <div id="my-ads" class="ads-grid" style="display: none;">
            @php $myAds = $ads->where('user_id', Auth::id()); @endphp

            @if($myAds->isEmpty())
                <p>У вас ещё нет объявлений.</p>
            @else
                @foreach($myAds as $ad)
                    <div class="ad-card">
                        @if($ad->image)
                            <img src="{{ asset('storage/' . $ad->image) }}" alt="" />
                        @endif
                        <div class="content">
                            <div class="title">{{ $ad->title }}</div>
                            <div class="description">{{ Str::limit($ad->description, 100) }}</div>
                            <div class="meta">Цена: {{ $ad->price }} тг • {{ \App\Http\Controllers\AdController::getCategories()[$ad->category] ?? $ad->category }}</div>
                            <div class="actions">
                                <button class="btn btn-warning" onclick="openEditAdModal({{ $ad->id }})">Редактировать</button>
                                <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Модальное окно для создания нового объявления -->
    <div id="createAdModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); justify-content: center; align-items: center; z-index: 999;">
        <div style="background: white; padding: 25px; border-radius: 12px; width: 400px; max-width: 90%;">
            <h3 style="margin-bottom: 15px;">Новое объявление</h3>
            <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="title" placeholder="Заголовок" required class="input-field">
                <textarea name="description" placeholder="Описание" required class="input-field"></textarea>
                <input type="text" name="price" placeholder="Цена (тг)" required class="input-field">
                <select name="category" required class="input-field">
                    @foreach(\App\Http\Controllers\AdController::getCategories() as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <input type="text" name="contact" placeholder="Контакты (тел./email)" required class="input-field">
                <input type="file" name="image" class="input-field">
                <button type="submit" class="btn-primary" style="margin-top: 10px; width: 100%;">Разместить</button>
            </form>
            <button onclick="closeCreateAdModal()" class="btn-secondary" style="margin-top: 10px; width: 100%;">Отмена</button>
        </div>
    </div>

    <!-- Модальное окно для редактирования объявления -->
    <div id="editAdModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); justify-content: center; align-items: center; z-index: 999;">
        <div style="background: white; padding: 25px; border-radius: 12px; width: 400px; max-width: 90%;">
            <h3 style="margin-bottom: 15px;" id="modalTitle">Редактировать объявление</h3>
            @foreach($ads as $ad)
                <form action="{{ route('ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data" id="editAdForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                    <input type="text" name="title" value="{{ old('title', $ad->title) }}" placeholder="Заголовок" required class="input-field" id="title">
                    <textarea name="description" placeholder="Описание" required class="input-field" id="description">{{ old('description', $ad->description) }}</textarea>
                    <input type="text" name="price" value="{{ old('price', $ad->price) }}" placeholder="Цена (тг)" required class="input-field" id="price">
                    <select name="category" required class="input-field" id="category">
                        @foreach(\App\Http\Controllers\AdController::getCategories() as $key => $value)
                            <option value="{{ $key }}" {{ $ad->category === $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="contact" value="{{ old('contact', $ad->contact) }}" placeholder="Контакты (тел./email)" required class="input-field" id="contact">
                    <input type="file" name="image" class="input-field" id="image">
                    @if ($ad->image)
                        <img src="{{ asset('storage/' . $ad->image) }}" alt="Текущее изображение" style="max-width: 100%; margin-top: 10px;">
                    @endif
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px; width: 100%;">Сохранить изменения</button>
                </form>
            @endforeach
            <button onclick="closeEditAdModal()" class="btn btn-secondary" style="margin-top: 10px; width: 100%;">Отмена</button>
        </div>
    </div>
    @auth
        @foreach (auth()->user()->unreadNotifications as $notification)
            <div class="alert alert-info">
                <strong>{{ $notification->data['title'] }}</strong><br>
                {{ $notification->data['message'] }}<br>
                <a href="{{ $notification->data['url'] }}">Открыть</a>
            </div>
        @endforeach
    @endauth


    <style>
        .input-field {
            width: 100%;
            padding: 8px 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #7e57c2;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-secondary {
            background-color: #eee;
            color: #333;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }
        #marketplace-section img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            display: block; /* Убедитесь, что изображение отображается как блок */
            margin-top: 10px; /* Можно добавить отступ сверху */
        }
        /* Модалки */
        .modal {
            display: none;
            position: fixed; top:0; left:0;
            width:100%; height:100%;
            background:rgba(0,0,0,0.4);
            justify-content:center; align-items:center;
            z-index:1000;
        }
        .modal-content {
            background:#fff; border-radius:12px;
            width:90%; max-width:400px; padding:24px;
        }
        .modal-content h3 {
            margin:0 0 16px; font-size:1.2rem; font-weight:600;
        }
        .modal-content .input-field {
            width:100%; padding:8px; margin-bottom:12px;
            border:1px solid #ccc; border-radius:6px;
            font-size:0.95rem;
        }

    </style>

    <script>



        document.addEventListener('DOMContentLoaded', function() {
            showNews();
            @if(session('successType') === 'request_sent')
            showNews();
            @endif
        });
        function hideAllSections() {
            document.getElementById('see-news-section').style.display = 'none';
            document.getElementById('housing-sidebar').style.display = 'none';
            document.getElementById('marketplace-section').style.display = 'none';
        }
        function showHousing() {
            hideAllSections()
            document.getElementById('housing-sidebar').style.display = 'block';
        }
        document.addEventListener("DOMContentLoaded", function () {
            const buildingSelect = document.getElementById("building");
            const floorSelect = document.getElementById("floor");
            const roomSelect = document.getElementById("room");

            async function loadFloors(buildingId) {
                if (!buildingId) {
                    floorSelect.innerHTML = '<option value="">{{ __('messages.choose_building_first') }}</option>';
                    floorSelect.disabled = true;
                    return;
                }
                try {
                    const response = await fetch(`/student/personal/floors/${buildingId}`);
                    const data = await response.json();
                    floorSelect.innerHTML = '<option value="">{{ __('messages.select_floor') }}</option>';
                    if (data.length === 0) {
                        floorSelect.innerHTML = '<option value="">{{ __('messages.no_floors') }}</option>';
                        floorSelect.disabled = true;
                        return;
                    }
                    data.forEach(floor => {
                        floorSelect.innerHTML += `<option value="${floor}">${floor}</option>`;
                    });
                    floorSelect.disabled = false;
                } catch (error) {
                    console.error("Error loading floors:", error);
                }
            }
            async function loadRooms(buildingId, floor) {
                if (!floor) {
                    roomSelect.innerHTML = '<option value="">{{ __('messages.choose_floor_first') }}</option>';
                    roomSelect.disabled = true;
                    return;
                }
                try {
                    const response = await fetch(`/student/personal/rooms/${buildingId}/${floor}`);
                    const data = await response.json();
                    roomSelect.innerHTML = '<option value="">{{ __('messages.select_room') }}</option>';
                    if (data.length === 0) {
                        roomSelect.innerHTML = '<option value="">{{ __('messages.no_rooms') }}</option>';
                        roomSelect.disabled = true;
                        return;
                    }
                    data.forEach(room => {
                        roomSelect.innerHTML += `<option value="${room.id}">${room.room_number}</option>`;
                    });
                    roomSelect.disabled = false;
                } catch (error) {
                    console.error("Error loading rooms:", error);
                }
            }
            buildingSelect.addEventListener("change", function () {
                const buildingId = this.value;
                loadFloors(buildingId);
                roomSelect.innerHTML = '<option value="">{{ __('messages.choose_floor_first') }}</option>';
                roomSelect.disabled = true;
            });
            floorSelect.addEventListener("change", function () {
                const buildingId = buildingSelect.value;
                const floor = this.value;
                loadRooms(buildingId, floor);
            });
        });
        function showMarketplace() {
            hideAllSections();
            document.getElementById('marketplace-section').style.display = 'block';
        }
        // Открытие модального окна для нового объявления
        function openCreateAdModal() {
            document.getElementById('createAdModal').style.display = 'flex';
        }

        // Закрытие модального окна для нового объявления
        function closeCreateAdModal() {
            document.getElementById('createAdModal').style.display = 'none';
        }

        // Открытие модального окна для редактирования объявления
        function openEditAdModal(adId) {
            // тут ваш fetch для заполнения полей и затем показ модалки:
            fetch(`/dashboard/ads/${adId}/edit`)
                .then(r => r.json())
                .then(data => {
                    const form = document.getElementById('editAdForm');
                    form.action = `/dashboard/ads/${adId}/update`;
                    document.getElementById('editTitle').value    = data.title;
                    document.getElementById('editDesc').value     = data.description;
                    document.getElementById('editPrice').value    = data.price;
                    document.getElementById('editCategory').value = data.category_id;
                    document.getElementById('editContact').value  = data.contact;
                    document.getElementById('editAdModal').style.display = 'flex';
                })
                .catch(() => alert('Ошибка загрузки объявления'));
        }
        // Закрытие модального окна для редактирования объявления
        function closeEditAdModal() {
            document.getElementById('editAdModal').style.display = 'none';
        }

    </script>
@endsection
