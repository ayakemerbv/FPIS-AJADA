{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="main-content">--}}
{{--        <h2>Заявки на заселение</h2>--}}

{{--        @if(session('success'))--}}
{{--            <div style="background-color: #d4edda; color: #155724; padding: 10px;">--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <table style="width:100%; border-collapse: collapse;">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Студент</th>--}}
{{--                <th>Корпус</th>--}}
{{--                <th>Этаж</th>--}}
{{--                <th>Комната</th>--}}
{{--                <th>Статус</th>--}}
{{--                <th>Действия</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($requests as $req)--}}
{{--                <tr style="border-bottom: 1px solid #ccc;">--}}
{{--                    <td>{{ $req->user->name }}</td>--}}
{{--                    <td>{{ $req->building_id }}</td>--}}
{{--                    <td>{{ $req->floor }}</td>--}}
{{--                    <td>{{ $req->room_id }}</td>--}}
{{--                    <td>{{ $req->status }}</td>--}}
{{--                    <td>--}}
{{--                        <a href="{{ route('booking.accept', $req->id) }}"--}}
{{--                           style="color: green; text-decoration: none; margin-right: 10px;">--}}
{{--                            Принять--}}
{{--                        </a>--}}
{{--                        <a href="{{ route('booking.reject', $req->id) }}"--}}
{{--                           style="color: red; text-decoration: none;">--}}
{{--                            Отклонить--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--@endsection--}}

