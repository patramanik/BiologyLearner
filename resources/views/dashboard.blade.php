@extends('layouts.master')
@section('title', 'Biology Learner')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-3">Dashboard</h1>
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="row">
            <!-- Total Catagorys Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class=" h6 text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Total Catagorys</div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $catagorys }}</div>
                            </div>
                            {{-- <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary-800"></i>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-dark stretched-link text-decoration-none"
                            href="{{ url('/admin/category') }}">View Details</a>
                        <div class="small text-dark"><i class="fas fa-angle-right "></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Posts Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h6 text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Total Posts</div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $posts }}</div>
                            </div>
                            {{-- <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary-800"></i>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-dark stretched-link text-decoration-none" href="{{ url('/admin/posts') }}">View
                            Details</a>
                        <div class="small text-dark"><i class="fas fa-angle-right "></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Posts Approval Request Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h6 text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Catagory Approval Request</div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $catagoryStatus }}</div>
                            </div>
                            {{-- <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary-800"></i>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-dark stretched-link text-decoration-none"
                            href="{{ url('/admin/publish') }}">View Details</a>
                        <div class="small text-dark"><i class="fas fa-angle-right "></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Posts Approval Request Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h6 text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Posts Approval Request</div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $postStatus }}</div>
                            </div>
                            {{-- <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary-800"></i>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-dark stretched-link text-decoration-none"
                            href="{{ url('/admin/post-publish') }}">View Details</a>
                        <div class="small text-dark"><i class="fas fa-angle-right "></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Comment -->
        <div class="card shadow mt-3">
            <h4 class="m-2">User Comment</h4>
            <div class="card-body table-responsive">
                <table id="user-comment" class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Sno.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commend as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->user_name }}</td>
                                <td>{{ $data->user_email }}</td>
                                <td>{{ $data->comment }}</td>
                                <td>
                                    <button type="button" data-id="{{ $data->id }}" class="btn btn-success btn-sm delete-comment" style="margin: 2px 2px 2px 2px" >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#user-comment').DataTable();

            $('.delete-comment').on('click', function() {
                var commentId = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '/delete-commend/' + commentId,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Delete!',
                            text: 'Comment delete successfully!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
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

            // console.log("jQuery is loaded! Version: " + jQuery.fn.jquery);
        });
    </script>
@endsection
