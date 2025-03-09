@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать новость</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')   Обязательно указываем метод PUT для обновления

            <div class="mb-3">
                <label class="form-label">Заголовок</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $news->title) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Содержание</label>
                <textarea
                    name="content"
                    class="form-control"
                    rows="5"
                    required
                >{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Картинка (опционально)</label>
                @if($news->image)
                    <div class="mb-2">
                        <img
                            src="{{ asset('storage/' . $news->image) }}"
                            alt="News Image"
                            style="max-width: 200px;"
                        >
                    </div>
                @endif
                <input
                    type="file"
                    name="image"
                    class="form-control"
                >
            </div>

            <button class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
