@extends('layouts.master')
@section('title', 'Edit Post')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <section>
        <div class="container-fluid px-4">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    <h5>Edit Post</h5>
                </div>
                <div class="card-body">
                    <form id="editPostForm" action="{{ url('/admin/updatepost/' . $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- <pre>
                            @php
                                print_r($errors->all());
                            @endphp
                        </pre> --}}
                        <div class="mb-3">
                            <label class="mb-2"> Selected Category</label>
                            <select class="form-select" name="catagory_id" aria-label="Default select example">
                                <option value="{{$post->category_id}}">{{$post->category_id}}</option>
                            </select>
                            <span class="alert-danger" style="color: red">
                                @error('catagory_id')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Post Name</label>
                            <input for="text" name="post_name" value="{{$post->post_name}}" class="form-control">
                            <span class="alert-danger" style="color: red">
                                @error('post_name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Mata Title</label>
                            <input for="text" name="metaTile" value="{{$post->meta_title}}" class="form-control">
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
                            <input for="texi" name="Post_keywords" value="{{$post->Post_keywords}}" class="form-control">
                            <span class="aleart-danger" style="color: red">
                                @error('Post_keywords')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class=" mb-3">
                            <label for="editor" class="form-label">Post Content</label>
                            <textarea class="form-control" name="Post_Content" id="editor" rows="5" >{{$post->post_content}}</textarea>
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

@endsection

@section('scripts')

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
    $(document).ready(function() {
        $('#editPostForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert('Post updated successfully!');
                    // Optionally, you can redirect the user or update the UI
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


