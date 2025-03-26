{{--    @extends('layouts.app')--}}

{{--    @section('content')--}}

{{--        <div class="container">--}}
{{--            <h2 class="mb-4 mt-5">Редактирование запроса #{{$repairRequest->id}}</h2>--}}

{{--            <a href="{{route('request.index')}}" class="btn btn-secondary mb-3">Назад</a>--}}

{{--            <!-- Форма редактирования -->--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <form action="{{ route('request.update', $repairRequest->id) }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        @method('PUT')--}}

{{--                        <!-- Тип запроса -->--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="type" class="form-label">Тип запроса</label>--}}
{{--                            <input type="text" id="type" name="type" class="form-control" value="{{ $repairRequest->type }}" required>--}}
{{--                        </div>--}}

{{--                        <!-- Описание -->--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="description" class="form-label">Описание</label>--}}
{{--                            <textarea id="description" name="description" class="form-control" rows="3" required>{{ $repairRequest->description }}</textarea>--}}
{{--                        </div>--}}

{{--                        <!-- Сотрудник -->--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="employee_id" class="form-label">Сотрудник</label>--}}
{{--                            <select id="employee_id" name="employee_id" class="form-control">--}}
{{--                                <option value="">Не назначен</option>--}}
{{--                                @foreach($employees as $employee)--}}
{{--                                    <option value="{{ $employee->id }}"--}}
{{--                                        {{ $repairRequest->employee_id == $employee->id ? 'selected' : '' }}>--}}
{{--                                        {{ $employee->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <!-- Кнопки действий -->--}}
{{--                        <button type="submit" class="btn btn-success">Сохранить изменения</button>--}}
{{--                        <a href="{{ route('request.show', $repairRequest->id) }}" class="btn btn-danger">Отмена</a>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    @endsection--}}
