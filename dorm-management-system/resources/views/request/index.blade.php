@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <a href="{{route('student.personal')}}">Назад</a>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title">Все запросы</h5>

                    <a href="{{route('request.create')}}" class="btn btn-primary btn-sm">➕</a>
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
                        @foreach($requests as $request)
                            <tr>
                                <td>{{$request->id}}</td>
                                <td><a href="{{route('request.show', $request->id)}}" class="text-primary text-decoration-none">{{$request->type}}</a></td>
                                <td>{{$request->created_at}}</td>
                                <td>{{$request->employee->name ?? 'Не назначен'}}</td>
                                <td><span class="badge bg-success">{{$request->status}}</span></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
