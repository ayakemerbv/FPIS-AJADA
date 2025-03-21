@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <a class="btn btn-outline-secondary" href="{{route('employee.dashboard')}}">Назад</a>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mt-3">Все запросы</h5>

                </div>
                <button class="btn btn-outline-secondary btn-sm mb-3">Выбрать период</button>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>№</th>
                            <th>Запрос</th>
                            <th>Дата</th>
                            <th>Сотрудник</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($repairRequests as $request)
                            <tr>
                                <td>{{$request->id}}</td>
                                <td><a href="{{route('employee.request.show', $request->id)}}" class="text-primary text-decoration-none">{{$request->type}}</a></td>
                                <td>{{$request->created_at}}</td>
                                <td>{{$request->employee->name ?? 'Не назначен'}}</td>
                                <td>
                                    @if($request->status == 'На рассмотрении')
                                        <span class="badge bg-warning text-dark">На рассмотрении</span>
                                    @elseif($request->status == 'Принято')
                                        <span class="badge bg-primary">Принято</span>
                                    @elseif($request->status == 'Выполнено')
                                        <span class="badge bg-success">Выполнено</span>
                                    @else
                                        <span class="badge bg-secondary">Неизвестно</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
