@extends('layouts.master')
@section('title', 'post')
@section('content')
    <div class="container-fluid px-4">

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card shadow  mt-3">
            <div class="card-header h4">
                Posts List
                <a href="{{ url('/admin/addpost') }}" class="btn btn-primary float-end">Add Post</a>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="post-table" class="table table-bordered table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Meta Title</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Keywords</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($post as $post)
                                <!-- Changed the variable name to 'posts' -->
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $post->post_name }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <!-- Assuming category relationship exists -->
                                    <td>
                                        <span class="d-inline-block text-truncate" style="max-width: 120px;">
                                            {{ $post->meta_title }}
                                        </span>
                                    </td>
                                    <td>
                                        <img src="{!! $post->image !!}" class="img-thumbnail" alt="image"
                                            height="50px" width="70px">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $post->id }}"
                                            style="margin: 2px 2px 2px 2px">View</button>
                                    </td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-{{ $post->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="modalLabel-{{ $post->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalLabel-{{ $post->id }}">
                                                        Description
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! $post->post_content !!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                    <td>
                                        <span class="d-inline-block text-truncate" style="max-width: 120px;">
                                            {{ $post->Post_keywords }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($post->status == 1)
                                            <span style="color: green">Publish</span>
                                        @else
                                            <span style="color: red">Not Publish</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/editPost/' . $post->id) }}" type="button"
                                            class="btn btn-dark btn-sm" style="margin: 2px 2px 2px 2px">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm delete-post"
                                            data-id="{{ $post->id }}" style="margin: 2px 2px 2px 2px">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#post-table').DataTable();
            $('.delete-post').click(function(e) {
                e.preventDefault();
                var postId = $(this).data('id');

                // SweetAlert2 confirmation prompt
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this Post?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/delete-post/' + postId,
                            type: 'POST',
                            data: {
                                _method: 'DELETE'
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                // Check if the error response contains our custom error message
                                let errorMessage = 'Error Deleting Post.';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                Swal.fire(
                                    'Error!',
                                    errorMessage,
                                    'error'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
