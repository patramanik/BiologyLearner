@extends('layouts.master')
@section('title', 'Edit Category')
@section('content')
    <section>
        <div class="container-fluid px-4">
            <div class="card mt-3 mb-2">
                <div class="card-header">
                    <h5>Edit Category</h5>
                </div>
                <div class="card-body">
                    <form id="editCategoryForm" action="{{ url('/admin/update/' . $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- First row: Category Name and Meta Title -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Category Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control"
                                        placeholder="Enter Category Name">
                                    <span class="alert-danger" style="color: red">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Meta Title
                                    </label>
                                    <input type="text" name="mataTile" value="{{ $category->mata_title }}"
                                        class="form-control" placeholder="Enter Meta Title">
                                    <span class="alert-danger" style="color: red">
                                        @error('mataTile')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Second row: Category Image and Keywords -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="image">
                                        Category Image <span class="text-danger">*</span>
                                    </label>
                                    <div class="card p-3">
                                        @if (isset($category->image))
                                            <img src="{{ $category->image }}" alt="Category Image" class="img-fluid mb-2"
                                                width="100">
                                        @endif
                                        <input type="file" class="form-control-file" id="image" name="image">
                                        <input type="hidden" name="old_image" id="old_image" value="{{ $category->image ?? '' }}">
                                    </div>
                                    <span class="alert-danger" style="color: red">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Keywords
                                    </label>
                                    <input type="text" name="keywords" value="{{ $category->c_keywords }}"
                                        class="form-control" placeholder="Enter Keywords">
                                    <span class="alert-danger" style="color: red">
                                        @error('keywords')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Third row: Description -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">
                                        Description
                                    </label>
                                    <textarea class="form-control" name="description" id="description" rows="3"
                                        placeholder="Enter Description">{{ $category->meta_description }}</textarea>
                                </div>
                                <span class="alert-danger" style="color: red">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Centered submit button -->
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize jQuery Validation on the form
            $("#editCategoryForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    image: {
                        required: function() {
                            return $("#old_image").val() === "";
                        },
                        extension: "jpg|jpeg|png|gif"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a category name."
                    },
                    image: {
                        required: "Please select an image.",
                        extension: "Please upload a valid image file (jpg, jpeg, png, gif)."
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
                            alert('Category updated successfully!');
                            // Optionally, you can redirect the user or update the UI
                        },
                        error: function(response) {
                            alert('An error occurred. Please try again.');
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endsection
