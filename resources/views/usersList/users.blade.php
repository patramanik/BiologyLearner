@extends('layouts.master')
@section('title', 'Users List')
@section('content')
    <style>
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1;
            border-radius: 0.2rem;
        }
    </style>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Users List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Users Status</th>
                                <th>Users Role</th>
                                <th>Created At</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <?php
                                //   dd($user);
                                ?>

                                <tr>
                                    {{-- <td>{{ $user->id }}</td> --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="btn btn-{{ $user->user_status == 1 ? 'success' : 'danger' }} btn-xs">
                                            {{ $user->user_status == 1 ? 'Active' : 'Suspended' }}
                                        </span>
                                    </td>


                                    <td>
                                        @if ($user->user_role == 1)
                                            <span class="btn btn-primary btn-xs">Developer</span>
                                        @elseif($user->user_role == 2)
                                            <span class="btn btn-primary btn-xs">User</span>
                                        @endif
                                    </td>

                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>

                                    <td>
                                        <button class="btn btn-danger btn-xs suspend-user"
                                            data-user-id="{{ $user->id }}">Suspend</button>
                                        <button class="btn btn-success btn-xs active-user"
                                            data-user-id="{{ $user->id }}">Active</button>
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
            $('#usersTable').DataTable();

            // Ajax request to suspend user with SweetAlert confirmation
            $('.suspend-user').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');

                // SweetAlert2 confirmation prompt
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to suspend this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, suspend it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/suspend/' + userId,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Update the status cell if applicable
                                var statusCell = $('tr[data-user-id="' + userId +
                                    '"] .user-status');
                                statusCell.html(
                                    '<span class="btn btn-danger btn-xs">Suspended</span>'
                                );

                                Swal.fire(
                                    'Suspended!',
                                    'User suspended successfully.',
                                    'success'
                                ).then(() => {
                                    // Reload the page after confirming the alert
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Error suspending user.',
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
