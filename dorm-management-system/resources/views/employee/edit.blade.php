@extends('layouts.app')

@section('content')

    <div class="container">
        <h2 class="mb-4 mt-5">Редактирование запроса #{{$request->id}}</h2>

        <a href="{{route('employee.requests')}}" class="btn btn-secondary mb-3">Назад</a>

        <!-- Форма редактирования -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('employee.request.update', $request->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
{{--                    {{$request->user_id}}--}}
{{--                    {{$request->employee_id}}--}}

                    <!-- Тип запроса -->
                    <div class="mb-3">
                        <label for="type" class="form-label">Тип запроса</label>
                        <input type="text" id="type" name="type" class="form-control" value="{{ $request->type }}" readonly>
                    </div>

                    <!-- Описание -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea id="description" name="description" class="form-control" rows="3" required readonly>{{ $request->description }}</textarea>
                    </div>

                    <!-- Сотрудник -->
{{--                    <div class="mb-3">--}}
{{--                        <label for="employee_id" class="form-label">Сотрудник</label>--}}
{{--                        <select id="employee_id" name="employee_id" class="form-control">--}}
{{--                                <option value="{{ $request->employee->name }}">--}}
{{--                                </option>--}}
{{--                        </select>--}}
{{--                    </div>--}}

                    <div class="mb-3">
                        <label for="status">Статус:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="На рассмотрении" @if($request->status == 'На рассмотрении') selected @endif>На рассмотрении</option>
                            <option value="Принято" @if($request->status == 'Принято') selected @endif>Принято</option>
                            <option value="Выполнено" @if($request->status == 'Выполнено') selected @endif>Выполнено</option>
                        </select>
                    </div>

                    <!-- Кнопки действий -->
                    <button type="submit" class="btn btn-success">Сохранить изменения</button>
                    <a href="{{ route('employee.request.show', $request->id) }}" class="btn btn-danger">Отмена</a>
                </form>
            </div>
        </div>
    </div>

@endsection
