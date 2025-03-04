@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создать новость</h1>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Заголовок</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Содержание</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Картинка (опционально)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-success">Создать</button>
        </form>
    </div>
@endsection
