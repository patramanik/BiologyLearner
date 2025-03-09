@extends('layouts.master')

@section('title', 'Search Results')

@section('content')
    <div class="container-fluid px-4">
        <h2>Search Results for "{{ $query }}"</h2>

        <h3>Posts</h3>
        @if($posts->count())
            <ul>
                @foreach ($posts as $post)
                    <li>
                        <a href="{{ url('/post/'.$post->id) }}">{{ $post->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No posts found.</p>
        @endif

        <h3>Categories</h3>
        @if($categories->count())
            <ul>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ url('/category/'.$category->id) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No categories found.</p>
        @endif
    </div>
@endsection
