{{--@extends('layouts.auth')--}}

{{--@section('title', 'Создание пользователя')--}}

{{--@section('content')--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-6">--}}
{{--            <h2 class="mb-4">Создать пользователя</h2>--}}

{{--            --}}{{-- Сообщение об успехе --}}
{{--            @if(session('success'))--}}
{{--                <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--            @endif--}}

{{--            --}}{{-- Вывод ошибок валидации --}}
{{--            @if($errors->any())--}}
{{--                <div class="alert alert-danger">--}}
{{--                    @foreach($errors->all() as $err)--}}
{{--                        <p>{{ $err }}</p>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            --}}{{-- Форма --}}
{{--            <form action="{{ route('admin.users.store') }}" method="POST">--}}
{{--                @csrf--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label">ФИО</label>--}}
{{--                    <input--}}
{{--                        type="text"--}}
{{--                        name="name"--}}
{{--                        class="form-control"--}}
{{--                        value="{{ old('name') }}"--}}
{{--                        required--}}
{{--                    >--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label">ID</label>--}}
{{--                    <input--}}
{{--                        type="text"--}}
{{--                        name="user_id"--}}
{{--                        class="form-control"--}}
{{--                        value="{{ old('user_id') }}"--}}
{{--                        required--}}
{{--                    >--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label">Email</label>--}}
{{--                    <input--}}
{{--                        type="email"--}}
{{--                        name="email"--}}
{{--                        class="form-control"--}}
{{--                        value="{{ old('email') }}"--}}
{{--                        required--}}
{{--                    >--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label">Пароль</label>--}}
{{--                    <input--}}
{{--                        type="password"--}}
{{--                        name="password"--}}
{{--                        class="form-control"--}}
{{--                        required--}}
{{--                    >--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label">Роль</label>--}}
{{--                    <select--}}
{{--                        name="role"--}}
{{--                        class="form-select"--}}
{{--                    >--}}
{{--                        <option--}}
{{--                            value="student"--}}
{{--                            @if(old('role') === 'student') selected @endif--}}
{{--                        >Студент</option>--}}
{{--                        <option--}}
{{--                            value="manager"--}}
{{--                            @if(old('role') === 'manager') selected @endif--}}
{{--                        >Менеджер</option>--}}
{{--                        <option--}}
{{--                            value="admin"--}}
{{--                            @if(old('role') === 'admin') selected @endif--}}
{{--                        >Админ</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <button type="submit" class="btn btn-success">Создать</button>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
