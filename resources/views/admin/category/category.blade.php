@extends('layouts.master')
@section('title', 'Category')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Category</h1>

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="card shadow table-responsive table-bordered mt-3 ">

            <table class="table  table-striped table-hover" slot="">
                <thead class="bg-dark text-bg-dark ">
                    <tr class="">
                        <th>Sno.</th>
                        <th>Name</th>
                        <th>Meta Title</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Keywords</th>
                        <th>Status</th>
                        <th>Acction</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($catagorys as $catagory)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $catagory->name }}</td>
                            <td>{{ $catagory->mata_title }}</td>
                            <td>
                                <img src="{!! $catagory->image !!}" class="img-thumbnail" alt="imges" height="50px"
                                    width="70px">
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop" style="margin: 2px 2px 2px 2px">View</button>
                            </td>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Description</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $catagory->meta_description }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Modal --}}
                            <td><span class="d-inline-block text-truncate" style="max-width: 120px;">
                                    {{ $catagory->c_keywords }}
                                </span></td>
                            <td>
                                @if ($catagory->status == 1)
                                    <span class="text-wrap" style="color: green">Publish</span>
                                @else
                                    <span style="color: red">Not Publish</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/admin/edit/' . $catagory->id) }}" type="button" class="btn btn-dark btn-sm"
                                    style="margin: 2px 2px 2px 2px">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm delete-category"
                                    data-id="{{ $catagory->id }}" style="margin: 2px 2px 2px 2px">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-category').on('click', function() {
                var categoryId = $(this).data('id');
                if (confirm('Are you sure you want to delete this category?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/admin/destroy/' + categoryId,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert('Category deleted successfully!');
                            location.reload();
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
