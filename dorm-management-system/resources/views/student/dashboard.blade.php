@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/studentDashboard.css') }}" rel="stylesheet">

    <div class="sidebar">
        <div class="sidebar-item" onclick="showNews()">
            <i class="fas fa-home"></i>
            <span>{{__('messages.main')}}</span>
        </div>
        @if(Auth::check() && Auth::user()->role === 'student' && !Auth::user()->student?->room_id)
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
        <form method="GET" action="{{ route('marketplace.index') }}" class="filter-form">
            <div class="filter-controls">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="{{ __('messages.search_placeholder') }}"
                       class="form-control" />

                <select name="category_id" class="form-control">
                    <option value="">{{ __('messages.all_categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="sort" class="form-control">
                    <option value="">{{ __('messages.sort_by_price') }}</option>
                    <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected':'' }}>
                        {{ __('messages.price_low_to_high') }}
                    </option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected':'' }}>
                        {{ __('messages.price_high_to_low') }}
                    </option>
                </select>

                <button type="submit" class="btn btn-primary">
                    {{ __('messages.search') }}
                </button>
            </div>
        </form>


        {{-- Заголовок и кнопки --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>🛍️{{__('messages.marketplace')}}</h2>
            <div style="display: flex; gap: 8px; align-items: center;">
                <button class="btn btn-primary" onclick="openCreateAdModal()" style="height: 32px; padding: 6px 12px; font-size: 13px;margin-top: -105px">
                    +
                </button>
                <button class="btn btn-secondary" onclick="toggleMyAds()" style="height: 32px; padding: 6px 12px; font-size: 13px;margin-top: -105px">
                    {{__('messages.my_ads')}}
                </button>
            </div>

        </div>

        {{-- Все объявления --}}
        <div id="all-ads" class="ads-grid">
            @foreach($ads as $ad)
                <div class="ad-card">
                    @if($ad->image_path)
                        <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" />
                    @endif
                    <div class="content">
                        <div class="title">{{ $ad->title }}</div>
                        <div class="description">{{ Str::limit($ad->description, 100) }}</div>
                        <div class="meta">
                            {{__('messages.price')}}: {{ $ad->price }} тг • {{ $ad->category->name }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Только ваши объявления --}}
        <div id="my-ads" class="ads-grid" style="display: none;">
            <div style="grid-column: 1/-1; margin-bottom: 15px;">
                <button class="btn btn-secondary" onclick="toggleMyAds()" style="height: 32px; padding: 6px 12px; font-size: 13px;">
                    <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
                </button>
            </div>

            @php $myAds = $ads->where('user_id', Auth::id()); @endphp

            @if($myAds->isEmpty())
                <p>{{__('messages.no_ads_yet')}}.</p>
            @else
                @foreach($myAds as $ad)
                    <div class="ad-card">
                        @if($ad->image_path)
                            <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}" />
                        @endif
                        <div class="content">
                            <div class="title">{{ $ad->title }}</div>
                            <div class="description">{{ Str::limit($ad->description, 100) }}</div>
                            <div class="meta">
                                {{__('messages.price')}}: {{ $ad->price }} тг • {{ $ad->category->name }}
                            </div>
                            <div class="actions">
                                <button class="btn btn-warning" onclick="openEditAdModal({{ $ad->id }})">{{__('messages.edit_ad')}}</button>
                                <form action="{{ route('ads.destroy', ['ad' => $ad->id]) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{__('messages.delete_ad')}}</button>
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
            <h3 style="margin-bottom: 15px;">{{__('messages.new_ad')}}</h3>
            <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div style="color: red; margin-bottom: 10px;">
                        <ul style="padding-left: 20px; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="text" name="title" placeholder="{{__('messages.title')}}" required class="input-field"  value="{{ old('title') }}">
                <textarea name="description" placeholder="{{__('messages.description')}}" required class="input-field"></textarea>
                <input type="number" name="price" placeholder="{{__('messages.price_placeholder')}}" required class="input-field">
                <select name="category_id" required class="input-field">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="contact" placeholder="{{__('messages.contact')}}" required class="input-field">
                <input type="file" name="image" class="input-field">
                <button type="submit" class="btn-primary" style="margin-top: 10px; width: 100%;">{{__('messages.create_ad')}}</button>
            </form>
            <button onclick="closeCreateAdModal()" class="btn-secondary" style="margin-top: 10px; width: 100%;">{{__('messages.cancel')}}</button>
        </div>
    </div>

    <!-- Модальное окно для редактирования объявления -->
    <div id="editAdModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); justify-content: center; align-items: center; z-index: 999;">
        <div style="background: white; padding: 25px; border-radius: 12px; width: 400px; max-width: 90%;">
            <h3 style="margin-bottom: 15px;" id="modalTitle">{{ __('messages.edit_ad_title') }}</h3>
            <form action="" method="POST" enctype="multipart/form-data" id="editAdForm">
                @csrf
                @method('PUT')
                <input type="text" name="title" placeholder="{{__('messages.title')}}" required class="input-field" id="title">
                <textarea name="description" placeholder="{{__('messages.description')}}" required class="input-field" id="description"></textarea>
                <input type="number" name="price" placeholder="{{__('messages.price_placeholder')}}" required class="input-field" id="price">
                <select name="category_id" required class="input-field" id="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="contact" placeholder="{{__('messages.contact')}}" required class="input-field" id="contact">
                <input type="file" name="image" class="input-field">
                <button type="submit" class="btn btn-primary" style="margin-top: 10px; width: 100%;">{{__('messages.save_changes')}}</button>
            </form>
            <button onclick="closeEditAdModal()" class="btn btn-secondary" style="margin-top: 10px; width: 100%;">{{__('messages.cancel')}}</button>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            showNews();
            @if(session('successType') === 'request_sent')
            showNews();
            @elseif(session('successType') === 'ad_updated')
            showMarketplace();
            @elseif(session('successType') === 'ad_deleted')
            showMarketplace();
            @elseif(session('successType') === 'ad_created')
            showMarketplace();
            @elseif(session('successType') === 'ads_searched')
            showMarketplace();
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
        function openEditAdModal(adId) {
            fetch(`/student/ads/${adId}/edit`)
                .then(response => response.json())
                .then(data => {
                    const form = document.getElementById('editAdForm');
                    form.action = `/student/ads/${adId}`;

                    // Заполняем поля формы
                    document.getElementById('title').value = data.title;
                    document.getElementById('description').value = data.description;
                    document.getElementById('price').value = data.price;
                    document.getElementById('category_id').value = data.category_id;
                    document.getElementById('contact').value = data.contact;

                    // Показываем модальное окно
                    document.getElementById('editAdModal').style.display = 'flex';
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Ошибка при загрузке объявления');
                });
        }

        function toggleMyAds() {
            const allAds = document.getElementById('all-ads');
            const myAds = document.getElementById('my-ads');

            if (myAds.style.display === 'none') {
                allAds.style.display = 'none';
                myAds.style.display = 'grid';
            } else {
                myAds.style.display = 'none'; // исправлено с 'nonegh'
                allAds.style.display = 'grid';
            }
        }
        // Закрытие модального окна для редактирования объявления
        function closeEditAdModal() {
            document.getElementById('editAdModal').style.display = 'none';
        }
    </script>
@endsection
