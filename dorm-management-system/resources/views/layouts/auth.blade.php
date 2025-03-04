{{-- resources/views/layouts/auth.blade.php --}}
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Dorm Management</title>
    <!-- Подключаем Bootstrap (пример CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    @yield('content')
</div>
</body>
</html>
