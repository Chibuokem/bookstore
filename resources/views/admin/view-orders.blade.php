@extends('layouts.dashboard_layout')
@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">orders</li>
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
                                        <th>Amount</th>
                                        <th>Reference number</th>
                                        <th>Book</th>
                                        <th>Added on</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->amount }}</td>
                                            <td>{{ $order->reference }}</td>
                                            <td>{{ $order->book->name }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>
                                                @if ($order->status == 1)<span
                                                    style="color: green; font-weight:bold;">Confirmed</span>@else <span style="color: red; font-weight:bold;">Pending</span>@endif
                                            </td>
                                            <td>
                                                @if ($order->status == 1) <button
                                                        class="disable-confirmation btn btn-danger"
                                                        data-url="{{ route('confirm.order', ['order' => $order->id]) }}">Disable
                                                    confirmation</button> @else <button class="confirm-order btn btn-danger"
                                                        data-url="{{ route('confirm.order', ['order' => $order->id]) }}">Confirm
                                                        order</button> @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <p>No orders found</p>
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
    $(document).on('click', '.confirm-order', function(e) {
        e.preventDefault();


        const url = $(this).data('url');
        swal({
                title: "Are you sure you want to confirm this order?",
                text: "User will be notified and will get value for the product immediately",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $.get(url)
                        .done((response) => {
                            successNoty(
                                `Order with reference : ${response.data.reference} was confirmed successfully`
                            );
                        })
                        .fail(failJson)
                        .always(() => $(this).html('Confirm'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });

    });

     $(document).on('click', '.disable-confirmation', function(e) {
        e.preventDefault();


        const url = $(this).data('url');
        swal({
                title: "Are you sure you want to disable confirmation?",
                text: "Order's status willl change to not paid",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $.get(url)
                        .done((response) => {
                            successNoty(
                                `Confirmation for order with reference : ${response.data.reference} was removed successfully`
                            );
                        })
                        .fail(failJson)
                        .always(() => $(this).html('Disable confirmation'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });

    });

</script>
@endsection
