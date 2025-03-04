@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Новости</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.news.create') }}" class="btn btn-primary mb-3">Создать новость</a>

        <table class="table">
            <thead>
            <tr>
                <th>Заголовок</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($newsList as $news)
                <tr>
                    <td>{{ $news->title }}</td>
                    <td>{{ $news->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Точно удалить?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Новостей нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
