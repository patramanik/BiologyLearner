@extends('layouts.master')
@section('title', 'Add Post')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <section>
        <div class="container-fluid px-4">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    <h4 class="mt-4">Add Post</h4>
                </div>

                <div class="card-body">
                    <form id="addPostForm" action="{{ url('/admin/addpost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <pre>
                            @php
                                print_r($errors->all());
                            @endphp
                        </pre> --}}
                        <div class="mb-3">
                            <label class="mb-2"> Select Category</label>
                            <select class="form-select" name="catagory_id" aria-label="Default select example">
                                <option selected="">------Select------</option>
                                @foreach ($catagorys as $catagory )
                                <option value="{{$catagory->id}}">{{$catagory->name}}</option>
                                @endforeach
                            </select>
                            <span class="alert-danger" style="color: red">
                                @error('catagory_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Post Name</label>
                            <input for="text" name="post_name" class="form-control">
                            <span class="alert-danger" style="color: red">
                                @error('post_name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Mata Title</label>
                            <input for="text" name="metaTile" class="form-control">
                            <span class="alert-danger" style="color: red">
                                @error('metaTile')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2" for="image">Post Image</label>
                            <div class="card">
                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                            <span class="alert-danger" style="color: red">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Keywords</label>
                            <input for="texi" name="Post_keywords" class="form-control">
                            <span class="aleart-danger" style="color: red">
                                @error('Post_keywords')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class=" mb-3">
                            <label for="editor" class="form-label">Post Content</label>
                            <textarea class="form-control" name="Post_Content" id="editor" rows="5" ></textarea>
                            <span class="alert-danger" style="color: red">
                                @error('Post_Content')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary ">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script> --}}
    <script src="{{ asset('public/ckeditor5/ckeditor.js') }}"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script> --}}
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'),{
                ckfinder: {
                    uploadUrl:'{{route('admin.blogPost.upload').'?_token='.csrf_token()}}'
                }
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#addPostForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    alert('Post added successfully!');
                    // Optionally, you can reset the form or redirect the user
                },
                error: function(response) {
                    alert('An error occurred. Please try again.');
                    // Optionally, handle validation errors and display them
                }
            });
        });
    });
</script>
@endsection


