@extends('layouts.master')
@section('title', 'Edit Category')
@section('content')
    <section>
        <div class="container-fluid px-4">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    <h4 class="mt-4">Edit Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/admin/update/' . $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="mb-2">Category Name</label>
                            <input for="text" name="name" value="{{ $category->name }}" class="form-control">
                            <span class="alert-danger" style="color: red">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Mata Title</label>
                            <input for="text" name="mataTile" value="{{ $category->mata_title }}" class="form-control">
                            <span class="alert-danger" style="color: red">
                                @error('mataTile')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2" for="image">Category Image</label>
                            <div class="card">
                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                            <span class="alert-danger" style="color: red">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" name="description" aria-label="With textarea">{{ $category->meta_description }}</textarea>
                        </div>
                        <span class="alert-danger" style="color: red">
                            @error('description')
                                {{ $message }}
                            @enderror
                        </span>

                        <div class="mb-3">
                            <label class="mb-2">Keywords</label>
                            <input for="texi" name="keywords" value="{{ $category->c_keywords }}" class="form-control">
                            <span class="aleart-danger" style="color: red">
                                @error('keywords')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
