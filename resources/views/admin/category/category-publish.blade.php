@extends('layouts.master')
@section('title', 'Publish')
@section('content')
    <div class="container-fluid px-4">
        <h2 class="mt-4">Category Publish</h2>

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="row">
            {{-- start not published catagorys --}}
            <div class="card col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 m-3 ">
                <h4 class="m-2">Not publish</h4>
                <div class="card-body table-responsive">
                    <table id="catagory-publish" class="table table-bordered table-striped table-hover" slot="">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Acction</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($catagorys as $data)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <img src="{!! $data->image !!}" class="img-thumbnail" alt="imges"
                                            height="50px" width="70px">
                                    </td>
                                    <td>
                                        @if ($data->status == 1)
                                            <span class="text-wrap" style="color: green">Publish</span>
                                        @else
                                            <span style="color: red">Not Publish</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm publish-category"
                                            data-id="{{ $data->id }}" style="margin: 2px 2px 2px 2px">Publish</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- End not published categorys --}}
            <div class="card col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 m-3">
                <h4 class="m-2"> Published</h4>
                <div class="table-responsive ">
                    <table id="catagory-published" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Acction</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($approval as $data)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>
                                        <img src="{!! $data->image !!}" class="img-thumbnail" alt="imges"
                                            height="50px" width="70px">
                                    </td>
                                    <td>
                                        @if ($data->status == 1)
                                            <span class="text-wrap" style="color: green">Publish</span>
                                        @else
                                            <span style="color: red">Not Publish</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm hide-category"
                                            data-id="{{ $data->id }}" style="margin: 2px 2px 2px 2px">Hide</button>
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
            $('#catagory-publish').DataTable();
            $('#catagory-published').DataTable();
            $('.publish-category').on('click', function() {
                var categoryId = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/admin/publish_catagory') }}/' + categoryId,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Category published successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('.hide-category').on('click', function() {
                var categoryId = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ url('admin/not_publish_category') }}/' + categoryId,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Category hidden successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
