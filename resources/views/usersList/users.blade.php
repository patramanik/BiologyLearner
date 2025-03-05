@extends('layouts.master')
@section('title', 'Users List')
@section('content')
<style>
    .btn-xs {
    padding: 0.25rem 0.5rem; /* Adjust padding as needed */
    font-size: 0.75rem;      /* Smaller font size */
    line-height: 1;          /* Adjust line height */
    border-radius: 0.2rem;   /* Optional: adjust border radius */
}
</style>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Users List</h4>
            </div>
            <div class="card-body">
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
                                @if($user->user_role == 1)
                                    <span class="btn btn-primary btn-xs">Developer</span>
                                @elseif($user->user_role == 2)
                                    <span class="btn btn-primary btn-xs">User</span>
                               
                                @endif
                            </td>
                            
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ url('admin/edituser/'.$user->id) }}" class="btn btn-danger btn-sm">Suspend</a>
                                {{-- <a href="{{ url('admin/deleteuser/'.$user->id) }}" class="btn btn-danger btn-sm">Delete</a> --}}
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
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();
        });
    </script>
@endsection
