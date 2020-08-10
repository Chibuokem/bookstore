@extends('layouts.dashboard_layout')
@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="books_table" class="table_data table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Phone number</th>
                                        <th>Added on</th> 
                                        <th>Delete user</th>     
                                        <th>Priviledge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->phone }}</td>
                                            
                                            <td>{{ $user->created_at }}</td>
                                          <td>
                                        <button class="delete-user btn btn-danger"
                                                        data-url="{{ route('delete.user', ['user' => $user->id]) }}">Delete user</button></td>
                                            <td>
                                                @if ($user->admin_level == 1) <button
                                                        class="make-admin btn btn-danger"
                                            data-id="{{$user->iid}}" data-status="0">Remove admin priviledge</button> @else <button class="make-admin btn btn-danger"
                                            data-id="{{$user->id}}" data-status="1">Make admin</button> @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <p>No users found</p>
                                    @endforelse

                                    </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->
@endsection

@section('script')
<script>
    $(document).on('click', '.delete-user', function(e) {
        e.preventDefault();


        const url = $(this).data('url');
        swal({
                title: "Are you sure you want to delete this user?",
                text: "User will be deleted immediately",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $.delete(url)
                        .done((response) => {
                            successNoty(
                                `User deleted successfully`
                            );
                        })
                        .fail(failJson)
                        .always(() => $(this).html('Delete'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });

    });

    $(document).on('click', '.make-admin', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const status  =  $(this).data('status');
        let fd = new FormData();
        fd.append('id', id);
        fd.append('status', status);
        swal({
                title: "Are you sure you want to change this users priviledges?",
                text: "User will now have different priviledge",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                   $.ajax({
                                    url: '{{route('switch-admin-status')}}',
                                    data: fd,
                                    type: 'POST',
                                    contentType: false,
                                    processData: false,
                                })
                                .done((response) => {
                                        
                                  successNoty(
                                        `User priviledge changed successfully`
                                    );
                                                              
                                  
                                })
                                .fail(failJson)
                                .always(() => $(this).html('Priviledge changed'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });

    });

</script>
@endsection
