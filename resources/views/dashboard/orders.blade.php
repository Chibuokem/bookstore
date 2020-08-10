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
                            <table id="orders_table" class="table_data table-bordered table-striped">
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
                                        <th>Download </th>
                                       
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
                                             @if ($order->status == 1) <a href="{{asset('storage/'.$order->book->bookfile)}}" target="_blank">Download</a> @else <span style="color: red; font-weight:bold;">You can't download yet</span>@endif
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

@endsection
