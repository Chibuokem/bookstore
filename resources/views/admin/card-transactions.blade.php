            @if($transactions['status'] == 'success')

              <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Transactions from {{$from}} - {{$to}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(is_array($transactions['data']))
                        <div class="table-responsive">
                            <table id="books_table" class="table_data table-bordered table-striped">
                                <thead>
                                    <tr>
   
                                        <th>id</th>
                                        <th>Amount</th>
                                        <th>Fee</th>
                                        <th>Product</th>
                                        <th>Gateway reference details</th>
                                        <th>Reference</th>
                                        <th>Gateway reference</th>
                                        <th>Amount confirmed</th>
                                        <th>Narration</th>
                                        <th>Indicator</th>
                                        <th>Created at</th>
                                        <th>Status</th>
                                        <th>Response message</th>
                                        <th>Currency</th>
                                       
                                        {{-- <th>View</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse ($transactions['data'] as $transaction)
                                        <tr>
                                            <td>{{ $transaction['id']}}</td>
                                            <td>{{ $transaction['amount'] }}</td>
                                            <td>{{ $transaction['fee'] }}</td>
                                            <td>{{ $transaction['product']}}</td>
                                            <td>{{ $transaction['gateway_reference_details'] }}</td>
                                            <td>{{ $transaction['reference']}}</td>
                                            <td>{{ $transaction['gateway_reference']}}</td>
                                            <td>{{ $transaction['amount_confirmed']}}</td>
                                            <td>{{ $transaction['narration']}}</td>
                                            <td>{{ $transaction['indicator']}}</td>
                                            <td>{{ $transaction['created_at']}}</td>
                                             <td>{{ $transaction['status']}}</td>
                                             <td>{{ $transaction['response_message']}}</td>
                                             <td>{{ $transaction['currency']}}</td>
                                           
                                            </tr>
                                        @empty
                                            <p>No transactions found</p>
                                        @endforelse
                                       
                                     

                                    </tfoot>
                            </table>
                        </div>
                        @else
                        <p>No transaction found</p>
                         @endif  

                    </div>
                    <!-- /.card-body -->
                </div>
                @else 
            <div class="alert alert-danger">{{$transactions['message']}}</div>
              @endif