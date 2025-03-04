{{--<?php--}}
{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h1 class="mb-4">Latest News</h1>--}}
{{--        @foreach ($news as $article)--}}
{{--            <div class="card mb-3">--}}
{{--                @if($article->image)--}}
{{--                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="News Image">--}}
{{--                @endif--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title">{{ $article->title }}</h5>--}}
{{--                    <p class="card-text">{{ Str::limit($article->content, 150) }}</p>--}}
{{--                    <a href="#" class="btn btn-primary">Read More</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}

{{--        {{ $news->links() }}--}}
{{--    </div>--}}
{{--@endsection--}}
