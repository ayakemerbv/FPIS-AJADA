{{--@extends('layouts.app')--}}

{{--@section('content')--}}

{{--    <div class="container">--}}
{{--        <h2 class="mb-4 mt-5">Детали запроса #{{$request->id}}</h2>--}}

{{--        <!-- Кнопки действий -->--}}
{{--        <div class="d-flex mb-3">--}}
{{--            <a href="{{route('employee.requests')}}" class="btn btn-secondary me-2">Назад</a>--}}
{{--            <a href="{{route('employee.request.edit', $request->id)}}" class="btn btn-primary me-2">Поменять статус</a>--}}
{{--        </div>--}}

{{--        <!-- Таблица с деталями запроса -->--}}
{{--        <table class="table table-bordered align-middle mb-4">--}}
{{--            <thead class="table-light">--}}
{{--            <tr>--}}
{{--                <th>№</th>--}}
{{--                <th>Запрос</th>--}}
{{--                <th>Подробнее</th>--}}
{{--                <th>Дата</th>--}}
{{--                <th>Сотрудник</th>--}}
{{--                <th>Статус</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            <tr>--}}
{{--                <td>{{$request->id}}</td>--}}
{{--                <td>{{$request->type}}</td>--}}
{{--                <td>{{$request->description}}</td>--}}
{{--                <td>{{$request->created_at->format('d.m.Y H:i')}}</td>--}}
{{--                <td>{{$request->employee->name ?? 'Не назначен'}}</td>--}}
{{--                <td>--}}
{{--                    @if($request->status == 'На рассмотрении')--}}
{{--                        <span class="badge bg-warning text-dark">На рассмотрении</span>--}}
{{--                    @elseif($request->status == 'Принято')--}}
{{--                        <span class="badge bg-primary">Принято</span>--}}
{{--                    @elseif($request->status == 'Выполнено')--}}
{{--                        <span class="badge bg-success">Выполнено</span>--}}
{{--                    @else--}}
{{--                        <span class="badge bg-secondary">Неизвестно</span>--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}

{{--    <!-- Модальное окно для подтверждения удаления -->--}}
{{--    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="deleteModalLabel">Удалить запрос?</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    Вы уверены, что хотите удалить этот запрос? Это действие нельзя отменить.--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>--}}
{{--                    <form action="{{route('request.destroy', $request->id)}}" method="POST">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="btn btn-danger">Удалить</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--@endsection--}}
