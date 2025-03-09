@extends('layouts.master')
@section('title', 'Add Post')
@section('content')
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <section>
        <div class="container-fluid px-4">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card mt-3 mb-2">
                        <div class="card-header">
                            <h5>Add Post</h5>
                        </div>
                        <div class="card-body">
                            <form id="addPostForm" action="{{ url('/admin/addpost') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- First row: Select Category and Post Name -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="catagory_id" class="form-label">
                                                Select Category <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="catagory_id" id="catagory_id">
                                                <option value="">------Select------</option>
                                                @foreach ($catagorys as $catagory)
                                                    <option value="{{ $catagory->id }}">{{ $catagory->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('catagory_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="post_name" class="form-label">
                                                Post Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="post_name" id="post_name" class="form-control" placeholder="Enter Post Name">
                                            <span class="text-danger">
                                                @error('post_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Second row: Meta Title and Keywords -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="metaTile" class="form-label">Meta Title</label>
                                            <input type="text" name="metaTile" id="metaTile" class="form-control" placeholder="Enter Meta Title">
                                            <span class="text-danger">
                                                @error('metaTile')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="Post_keywords" class="form-label">Keywords</label>
                                            <input type="text" name="Post_keywords" id="Post_keywords" class="form-control" placeholder="Enter Keywords">
                                            <span class="text-danger">
                                                @error('Post_keywords')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Third row: Post Image -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">
                                                Post Image <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" class="form-control" id="image" name="image">
                                            <span class="text-danger">
                                                @error('image')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fourth row: Post Content -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="editor" class="form-label">
                                                Post Content <span class="text-danger">*</span>
                                            </label>
                                            <!-- The textarea will be replaced by CKEditor -->
                                            <textarea class="form-control" name="Post_Content" id="editor" placeholder="Enter Post Content"></textarea>
                                            <span class="text-danger">
                                                @error('Post_Content')
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
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
    // Initialize CKEditor and set the desired min-height for the editable area
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: '{{ route('admin.blogPost.upload').'?_token='.csrf_token() }}'
            }
        })
        .then(editor => {
            // Optionally, you can log the editor instance
            // console.log(editor);
        })
        .catch(error => {
            // console.error(error);
        });

    // Initialize jQuery validation on the form
    $(document).ready(function() {
        $("#addPostForm").validate({
            rules: {
                catagory_id: {
                    required: true
                },
                post_name: {
                    required: true,
                    minlength: 3
                },
                metaTile: {
                    required: false
                },
                Post_keywords: {
                    required: false
                },
                image: {
                    required: true,
                    extension: "jpg|jpeg|png|gif"
                },
                Post_Content: {
                    required: true
                }
            },
            messages: {
                catagory_id: {
                    required: "Please select a category"
                },
                post_name: {
                    required: "Please enter the post name",
                    minlength: "Post name must be at least 3 characters long"
                },
                image: {
                    required: "Please select an image",
                    extension: "Only image files are allowed (jpg, jpeg, png, gif)"
                },
                Post_Content: {
                    required: "Please enter the post content"
                }
            },
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.prop("type") === "file") {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('Post added successfully!');
                        window.location.href = '/admin/posts';
                    },
                    error: function(response) {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });
    });
</script>
@endsection
