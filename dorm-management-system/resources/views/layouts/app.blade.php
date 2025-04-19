<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'DMS')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #F5F5F5;
    }

    .icon-circle,
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #6f42c1;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
    }

    .avatar-circle-big {
        width: 45px;
        height: 45px;
        font-size: 20px;
        margin: 0 auto 8px;
    }

    .top-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 60px;
        padding: 0 20px;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
    }

    .logo-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #4A4A4A;
        font-size: 24px;
        font-weight: bold;
    }

    .logo-img {
        height: 40px;
        margin-right: 10px;
    }

    .nav-icons {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .avatar-dropdown {
        display: none;
        position: absolute;
        top: 110%;
        right: 0;
        width: 180px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 999;
        text-align: center;
    }

    .avatar-wrapper:hover .avatar-dropdown {
        display: block;
    }

    .avatar-dropdown a {
        display: block;
        margin: 8px 0;
        text-decoration: none;
        color: #333;
        font-size: 14px;
    }

    .avatar-dropdown a:hover {
        text-decoration: underline;
    }

    .logout-form button {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 14px;
        cursor: pointer;
        padding: 0;
        margin-top: 8px;
    }

    .logout-form button i {
        margin-right: 5px;
    }

    .news-item {
        background-color: #B0A5D7;
        padding: 15px;
        color: #fff;
        max-width: 1500px;
        height: 240px;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .news-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .news-item h3 {
        margin-bottom: 10px;
    }

    .news-item small {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    /* News Styles */
    .news-item {
        background-color: #B0A5D7;
        padding: 15px;
        color: #fff;
        max-width: 1500px;
        height: 240px;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .news-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .news-item h3 {
        margin-bottom: 10px;
    }

    .news-item small {
        font-size: 0.85rem;
        opacity: 0.9;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        width: 100%;
        position: relative;
    }

    .modal-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 25px;
        font-weight: bold;
        cursor: pointer;
    }

</style>

<body>
{{-- Верхнее меню --}}
<div class="top-nav">
    <!-- Верхняя панель с логотипом и аватаром -->
    <a href="{{ route('student.dashboard') }}" class="logo-link">
        <img src="{{ asset('storage/icon/dark_icon.png') }}" alt="DMS Logo" class="logo-img">
        <span>DMS</span>
    </a>
    <div class="nav-icons">
        <!-- Иконки и переключатель языка -->
        <div class="text-message">
            @if(session('language_switched'))
                <p>You have switched to <span class="language">{{session('language_switched') === 'en' ? 'English' : (session('language_switched') == 'ru' ? "Russian" : "Kazakh")}} language</span></p>
            @endif
            <div class="text-messages">
                <p>{{__('messages.welcome')}}</p>
            </div>
        </div>
        <div>
            @include('components.language-switch')
        </div>
        <div class="icon-circle" style="background-color: #ffc107;">
            <i class="fas fa-bell"></i>
        </div>
        <div class="avatar-wrapper">
            <div class="avatar-circle">
                {{ mb_substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="avatar-dropdown">
                <div class="avatar-circle avatar-circle-big">
                    {{ mb_substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div>{{ Auth::user()->name }}</div>
                @if(Auth::user()->role === 'student')
                    <a href="{{ route('student.personal') }}">{{ __('messages.my_profile') }}</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i>{{ __('messages.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Боковая панель --}}
<div class="sidebar">
    <div class="sidebar-item" onclick="showNews()">
        <i class="fas fa-home"></i>
        <span>{{ __('messages.main') }}</span>
    </div>
    <!-- Другие элементы боковой панели -->
</div>

@yield('content')

<div class="main-content" id="see-news-section">
    <h2>{{ __('messages.news') }}</h2>
    @isset($newsList)
        <div class="news-cards-container">
            @foreach($newsList as $news)
                <div class="news-item" onclick="openNewsModal({{ $news->id }})">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="News Image">
                    @endif
                    <h3>{{ $news->title }}</h3>
                    <p>{{ Str::limit($news->content, 100) }}...</p>
                    <small>{{ $news->created_at->format('d.m.Y H:i') }}</small>
                </div>
            @endforeach
        </div>
    @else
        <p>{{ __('messages.no_news') }}</p>
    @endisset
</div>

{{-- Модальное окно для новости --}}
<div id="newsModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeNewsModal()">&times;</span>
        <h3 id="modalTitle"></h3>
        <img id="modalImage" src="" alt="News Image" class="modal-image">
        <p id="modalContent"></p>
        <small id="modalDate"></small>
    </div>
</div>

<script>
    // Открытие модального окна
    function openNewsModal(newsId) {
        const news = @json($newsList);
        const selectedNews = news.find(item => item.id === newsId);

        document.getElementById('modalTitle').innerText = selectedNews.title;
        const modalImage = document.getElementById('modalImage');
        modalImage.src = selectedNews.image ? '/storage/' + selectedNews.image : '';

        document.getElementById('modalContent').innerText = selectedNews.content;
        document.getElementById('modalDate').innerText = selectedNews.created_at;

        document.getElementById('newsModal').style.display = 'flex';
    }
    function closeNewsModal() {
        document.getElementById('newsModal').style.display = 'none';
    }
    function showNews() {
        hideAllSections();
        document.getElementById('see-news-section').style.display = 'block';
    }

</script>
</body>

</html>
