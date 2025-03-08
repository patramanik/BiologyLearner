@extends('layouts.master')
@section('title', 'Add-Category')
@section('content')
<div class="container-fluid px-4">
  <div class="card mt-3 mb-2">
    <div class="card-header">
      <h5>Add Category</h5>
    </div>
    <div class="card-body">
      <form id="addCategoryForm" action="{{ url('/admin/addcategory') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Category Name</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Enter Category Name">
        </div>
        <div class="mb-3">
          <label for="mataTile" class="form-label">Meta Title</label>
          <input type="text" name="mataTile" id="mataTile" class="form-control" placeholder="Enter Meta Title">
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">Category Image</label>
          <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description"></textarea>
        </div>
        <div class="mb-3">
          <label for="keywords" class="form-label">Keywords</label>
          <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Enter Keywords">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  var validator = $("#addCategoryForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 2
      },
      mataTile: {
        required: false
      },
      image: {
        required: true,
        extension: "jpg|jpeg|png|gif"
      },
      description: {
        required: false
      },
      keywords: {
        required: false
      }
    },
    messages: {
      name: {
        required: "Please enter a category name",
        minlength: "Category name must be at least 2 characters long"
      },
      mataTile: {
        required: "Please enter a meta title"
      },
      image: {
        required: "Please select an image",
        extension: "Please upload a valid image file (jpg, jpeg, png, gif)"
      },
      description: {
        required: "Please provide a description"
      },
      keywords: {
        required: "Please enter some keywords"
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
        event.preventDefault();
      var formData = new FormData(form);
      $.ajax({
        type: 'POST',
        url: $(form).attr('action'),
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          alert('Category added successfully!');
          window.location.href = '/admin/category';
        },
        error: function(response) {
          alert('An error occurred. Please try again.');
        }
      });
    }
  });

  // **Fix for Image Validation**
  $("#image").change(function() {
    if ($(this).val() !== "") {
      $(this).removeClass("is-invalid").addClass("is-valid");
      validator.element("#image"); // Manually trigger validation for image field
    }
  });
});
</script>
@endsection
