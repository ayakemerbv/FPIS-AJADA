{{--@extends('layouts.auth')--}}

{{--@section('title', 'Список пользователей')--}}

{{--@section('content')--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <h2 class="mb-4">Все пользователи</h2>--}}

{{--            <table class="table">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>Имя</th>--}}
{{--                    <th>ID</th>--}}
{{--                    <th>Email</th>--}}
{{--                    <th>Роль</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @forelse($users as $user)--}}
{{--                    <tr>--}}
{{--                        <td>{{ $user->name }}</td>--}}
{{--                        <td>{{ $user->user_id }}</td>--}}
{{--                        <td>{{ $user->email }}</td>--}}
{{--                        <td>{{ $user->role }}</td>--}}
{{--                    </tr>--}}
{{--                @empty--}}
{{--                    <tr>--}}
{{--                        <td colspan="3">Нет пользователей</td>--}}
{{--                    </tr>--}}
{{--                @endforelse--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
