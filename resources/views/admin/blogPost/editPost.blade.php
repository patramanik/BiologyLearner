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
                        <!-- First row: Select Category and Post Name -->
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="mb-2"> Selected Category
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="catagory_id" aria-label="Default select example">
                                    <option value="{{$post->category_id}}">{{$post->category_name}}</option>
                                </select>
                                <span class="alert-danger" style="color: red">
                                    @error('catagory_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="mb-2">Post Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input for="text" name="post_name" value="{{$post->post_name}}" class="form-control">
                                <span class="alert-danger" style="color: red">
                                    @error('post_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <!-- Second row: Meta Title and Keywords -->
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="mb-2">Mata Title</label>
                                <input for="text" name="metaTile" value="{{$post->meta_title}}" class="form-control">
                                <span class="alert-danger" style="color: red">
                                    @error('metaTile')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="mb-2">Keywords</label>
                                <input for="texi" name="Post_keywords" value="{{$post->Post_keywords}}" class="form-control">
                                <span class="aleart-danger" style="color: red">
                                    @error('Post_keywords')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Third row: Post Content -->
                        <div class="mb-3">
                            <label for="editor" class="form-label">Post Content
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="Post_Content" id="editor" rows="5" >{{$post->post_content}}</textarea>
                            <span class="alert-danger" style="color: red">
                                @error('Post_Content')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- Second row: Post Image and Keywords -->
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-3 text-center">
                                <div class="mb-3">
                                    <label class="form-label" for="image">
                                        Post Image <span class="text-danger">*</span>
                                    </label>
                                    <div class="card p-3">
                                        @if (isset($post->image))
                                            <img src="{{ $post->image }}" alt="Post Image" class="img-fluid mb-2"
                                                width="100">
                                        @endif
                                        <input type="file" class="form-control-file" id="image" name="image">
                                        <input type="hidden" name="old_image" id="old_image"
                                            value="{{ $post->image ?? '' }}">
                                    </div>
                                    <span class="alert-danger" style="color: red">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Fifth row: Submit Button -->
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<!-- Add this CSS rule to enforce the CKEditor editable area height -->
<style>
    /* Force the CKEditor editable area to always have a minimum height of 250px */
    .ck-editor__editable {
        min-height: 250px !important;
    }
</style>

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
                    Swal.fire({
                                title: 'Success!',
                                text: 'Post updated successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/admin/posts';
                                }
                            });
                },
                error: function(response) {
                    Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred. Please try again.',
                            confirmButtonText: 'OK'
                        });
                }
            });
        });
    });
</script>
@endsection


