@extends('layouts.dashboard_layout')
@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Virtual cards</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">virtual cards</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <a class="link" target="_blank" href="{{ route('create-new-card') }}">Create new card</a>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Virtual cards</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="books_table" class="table_data table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Billing name</th>
                                        <th>Currency</th>
                                        <th>Amount</th>
                                        <th>Billing country</th>
                                        <th>Billing address</th>
                                        <th>Billing city</th>
                                        <th>Billing state</th>
                                        <th>Masked pan</th>
                                        <th>Fund card</th>
                                        <th>Withdraw from card</th>
                                        <th>View card</th>
                                        <th>Change card status</th>
                                        <th>Terminate card</th>
                                        <th>View transactions</th>
                                        {{-- <th>View</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cards as $card)
                                        <tr>
                                            <td>{{ $card->id }}</td>
                                            <td>{{ $card->billing_name }}</td>
                                            <td>{{ $card->currency }}</td>
                                            <td>{{ $card->amount }}</td>
                                            <td>{{ $card->billing_country }}</td>
                                            <td>{{ $card->billing_address }}</td>
                                            <td>{{ $card->billing_city }}</td>
                                            <td>{{ $card->billing_state }}</td>
                                            <td>{{ $card->masked_pan }}</td>
                                            <td><button class="btn btn-primary" onClick="fundCard('{{ $card->card_id }}')">Fund
                                                    card</button></td>


                                            <td><button class="btn btn-primary"
                                                    onClick="withdrawFromCard('{{ $card->card_id }}')">Withdraw from
                                                    card</button>
                                            </td>
                                            <td>
                                                @if ($card->card_id != '')
                                                    <button class="get-card btn btn-primary"
                                                        data-url="{{ route('get.card', ['id' => $card->card_id]) }}">View
                                                        card detail</button>
                                                @else
                                                    <span style="font-weight:bold; color:red;">Card was not created successfully
                                                        on the paygate</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($card->card_id != '')

                                                    @if ($card->is_active == 1)
                                                        <button class="block-card btn btn-primary"
                                                            data-url="{{ route('block.card', ['card' => $card->id]) }}">Block
                                                            card
                                                        </button>
                                                    @else
                                                        <button class="unblock-card btn btn-primary"
                                                            data-url="{{ route('unblock.card', ['card' => $card->id]) }}">Unblock
                                                            card
                                                        </button>

                                                    @endif

                                                @else
                                                    <span style="font-weight:bold; color:red;">Card was not created successfully
                                                        on the paygate</span>
                                                @endif
                                            </td>
                                              <td>
                                                @if ($card->card_id != '')
                                                    <button class="terminate-card btn btn-danger"
                                                        data-url="{{ route('terminate.card', ['card' => $card->card_id]) }}">Terminate card</button>
                                                @else
                                                    <span style="font-weight:bold; color:red;">Card was not created successfully
                                                        on the paygate</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-primary"
                                                    onClick="getTransactions('{{ $card->card_id }}')">View transactions</button>
                                            </td>

                                        </tr>
                                    @empty
                                        <p>No cards found</p>
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
    $(document).ready(function() {
        //handle book upload here
        $("#create").click(function(e) {
            e.preventDefault();
            //var name = $(this).attr('data-id');
            const name = $("#billing_name").val();
            const address = $("#billing_address").val();
            const amount = $("#amount").val();
            const country = $("#country").val();
            const city = $("#city").val();
            const postalCode = $("#postal_code").val();
            const currency = $("#currency").val();
            const state = $("#state").val();
            if (name == "") {
                errorDisplay("Please enter your  name");
                return;
            }

            if (address == "") {
                errorDisplay("Please enter your address");
                return;
            }
            if (amount == "") {
                errorDisplay("Please enter amount");
                return;
            }

            if (state == "") {
                errorDisplay("Please enter state");
                return;
            }


            const myForm = $('form#virtual_card_form');
            swal({
                    title: "Are you sure you want to create this card?",
                    text: "Your account will be debitted for this",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((will) => {
                    if (will) {
                        //user accepted starts here
                        $('#create').html('Sending...');
                        $.ajax({
                                url: myForm.attr('action'),
                                data: myForm.serialize(),
                                type: 'POST',
                                contentType: false,
                                processData: false,
                            })
                            .done((response) => {
                                //let receiever = response.data.receiver;
                                successNoty(`Card  was created  successfully`);
                                //$('#content-container').load(`${location.href} #content-container`);
                            })
                            .fail(failJson)
                            .always(() => $('#create').html('Create card'));
                        //use accepted ends here
                    } else {
                        swal("Your action has been cancelled!");
                    }
                });

        });
    });

    const viewCard = (data) => {
        const form = $('#_empty_modal_content');
        form.html('');
        if (data.status == 'success') {
            const cardData = data.data;
            let cardStatus = cardData.is_active;
            let status = ""
            if (cardStatus == 1 || cardStatus == true) {
                status = "Active";
            } else {
                status = "Inactive";
            }
            form.append(`
           <div class="card">
            <div class="card-header">
              <h3 class="card-title">Your card detail</h3>
            </div>
    <div class="card-body">
      <p>Account id : ${cardData.account_id}</p>
      <p>Amount : ${cardData.amount}</p>
      <p>Currency : ${cardData.currency}</p>
      <p>Card Pan : ${cardData.card_pan}</p>
      <p>City : ${cardData.city}</p>
      <p>State : ${cardData.state}</p>
      <p>Address : ${cardData.address_1}</p>
      <p>Zip code : ${cardData.zip_code}</p>
      <p>Cvv : ${cardData.cvv}</p>
      <p>Expiration : ${cardData.expiration}</p>
      <p>Card type : ${cardData.card_type}</p>
      <p>Name on card: ${cardData.name_on_card}</p>
      <p>Status : ${status}</p>

     </div>
    </div>       
    `);
        } else {
            errorDisplay(data.message)
            form.append(`<div class="alert alert-danger>${data.message}</div>`);
        }

    };

    $(document).on('click', '.get-card', function(e) {
        e.preventDefault();

        $(this).html('loading ...');
        $('#emptyModal').modal('show');
        $('#_empty_modal_content').html('loading ...');

        const url = $(this).data('url');

        $.get(url)
            .done((response) => {
                viewCard(response.data);
            })
            .fail(failJson)
            .always(() => $(this).html('View Card detail'));
    });

    $(document).on('click', '.block-card', function(e) {
        e.preventDefault();
        const url = $(this).data('url');

        swal({
                title: "Are you sure you want to block this card?",
                text: "You will not be able to use this card again",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $.get(url)
                        .done((response) => {
                            if (response.data.status == 'success') {
                                successNoty(`${response.data.message}`);
                            } else {
                                errorDisplay(`${response.data.message}`)
                            }
                        })
                        .fail(failJson)
                        .always(() => $(this).html('Block card'));

                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }

            });
    });
    $(document).on('click', '.unblock-card', function(e) {
        e.preventDefault();


        const url = $(this).data('url');

        swal({
                title: "Are you sure you want to unblock this card?",
                text: "You will now be able to use this card again",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $.get(url)
                        .done((response) => {
                            if (response.data.status == 'success') {
                                successNoty(`${response.data.message}`);
                            } else {
                                errorDisplay(`${response.data.message}`)
                            }
                        })
                        .fail(failJson)
                        .always(() => $(this).html('Block card'));

                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }

            });
    });

    $(document).on('click', '#fund-card', function(e) {
        e.preventDefault();
        let amount = $("#amount").val();
        let debitCurrency = $("#debit_currency").val();

        if (amount == "") {
            errorDisplay("Please enter the amount you want to fund your card with");
            return;
        }

        if (debitCurrency == "") {
            errorDisplay("Please choose the currency you wish to fund your account with");
            return;
        }

        var fd = new FormData();

        const myForm = $('form#fund-card-form');
        //get other data inside the form
        var other_data = myForm.serializeArray();

        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });
        swal({
                title: "Are you sure you want to fund this card?",
                text: "Your balance will be debitted immediately",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $('#fund-card').html('Sending...');
                    $.ajax({
                            url: myForm.attr('action'),
                            data: fd,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                        })
                        .done((response) => {
                            if (response.data.status == 'success') {
                                successNoty(`${response.data.message}`);
                            } else {
                                errorDisplay(`${response.data.message}`)
                            }

                            //$('#content-container').load(`${location.href} #content-container`);
                        })
                        .fail(failJson)
                        .always(() => $('#fund-card').html('Fund card'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });

    });

    const fundCard = (id) => {
        const form = $('#_empty_modal_content');
        if (id == "") {
            errorDisplay("Sorry this card cannot be funded, as the card creation failed");
        }
        $('#emptyModal').modal('show');
        $('#_empty_modal_content').html('loading ...');
        form.html('');
        form.append(`
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Fund card</h3>
            </div>
    <div class="card-body">
    <form id="fund-card-form" action="{{ route('fund-card') }}">@csrf <div class="card-body">
              <input type="hidden" name="id" value="${id}"/>
             <div class="form-group">
                  <label for="amount">Amount</label>
                <input type="number" name="amount" class="form-control" id="amount"/>        
              </div>

              <div class="form-group">
                 <label for="type">Debit Currency</label>
                <select id="debit_currency" name="debit_currency" class="form-control">
                  <option value="NGN" selected>NGN</option>
                  <option value="USD">USD</option>
                  </select>
              
              </div> 
            
              
              <div class="form-group">
                <button class="btn btn-primary btn-lg" id="fund-card">Fund card</button>
              </div>
            </div>
          </form>
     </div>
    </div>       
    `);
    };

    $(document).on('click', '#withdraw', function(e) {
        e.preventDefault();
        let amount = $("#wirthdrawal_amount").val();

        if (amount == "") {
            errorDisplay("Please enter the amount you want to withdraw from the card");
            return;
        }


        var fd = new FormData();

        const myForm = $('form#withdrawal-form');
        //get other data inside the form
        var other_data = myForm.serializeArray();

        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });
        swal({
                title: "Are you sure you want to withdraw from this card?",
                text: "Your balance will be debitted immediately",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $('#withdraw').html('Sending...');
                    $.ajax({
                            url: myForm.attr('action'),
                            data: fd,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                        })
                        .done((response) => {
                            if (response.data.status == 'success') {
                                successNoty(`${response.data.message}`);
                            } else {
                                errorDisplay(`${response.data.message}`)
                            }

                            //$('#content-container').load(`${location.href} #content-container`);
                        })
                        .fail(failJson)
                        .always(() => $('#withdraw').html('Withdraw'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });

    });
    const withdrawFromCard = (id) => {
        const form = $('#_empty_modal_content');
        if (id == "") {
            errorDisplay("Sorry you cannot withdraw from this card, as the card creation failed");
        }
        $('#emptyModal').modal('show');
        $('#_empty_modal_content').html('loading ...');
        form.html('');
        form.append(`
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Withdraw from card</h3>
            </div>
    <div class="card-body">
    <form id="withdrawal-form" action="{{ route('withdraw') }}">@csrf <div class="card-body">
              <input type="hidden" name="id" value="${id}"/>
             <div class="form-group">
                  <label for="amount">Amount</label>
                <input type="number" name="amount" class="form-control" id="withdrawal_amount"/>        
              </div>

            
              
              <div class="form-group">
                <button class="btn btn-primary btn-lg" id="withdraw">Withdraw</button>
              </div>
            </div>
          </form>
     </div>
    </div>       
    `);
    };

</script>
<script>
    const getTransactions = (id) => {
        const form = $('#_empty_modal_content');
        if (id == "") {
            errorDisplay("Sorry you cannot view transactions from this card, as the card creation failed");
        }
        $('#emptyModal').modal('show');
        $('#_empty_modal_content').html('loading ...');
        form.html('');
        form.append(`
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Transactions</h3>
            </div>
    <div class="card-body">
    <form id="transactions-form" action="{{ route('view-transactions') }}">@csrf <div class="card-body">
              <input type="hidden" name="id" value="${id}"/>
             <div class="form-group">
                  <label for="daterange">Date range</label>
                    <input type="text" name="daterange" id="daterange"/>
              </div>
   
              <div class="form-group">
                <button class="btn btn-primary btn-lg" id="view-transactions">View transactions</button>
              </div>
            </div>
          </form>
     </div>
    </div>       
    `);

        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            locale: {
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });

    };


    $(document).on('click', '#view-transactions', function(e) {
        e.preventDefault();
        let daterange = $("#daterange").val();

        if (daterange == "") {
            errorDisplay("Please select a date range ");
            return;
        }
        var fd = new FormData();

        const myForm = $('form#transactions-form');
        //get other data inside the form
        var other_data = myForm.serializeArray();

        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });

        $.ajax({
                url: myForm.attr('action'),
                data: fd,
                type: 'POST',
                contentType: false,
                processData: false,
            })
            .done((response) => {
                //show transactions
                //$('#emptyModal').modal('show');
                $('#_empty_modal_content').html(response);

                //$('#content-container').load(`${location.href} #content-container`);
            })
            .fail(failJson)
            .always(() => $('#withdraw').html('Withdraw'));

    });

 $(document).on('click', '.terminate-card', function(e) {
        e.preventDefault();
        const url = $(this).data('url');

        swal({
                title: "Are you sure you want to terminate this card?",
                text: "You will be destroying this card permanently",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $.get(url)
                        .done((response) => {
                            if (response.data.status == 'success') {
                                successNoty(`${response.data.message}`);
                            } else {
                                errorDisplay(`${response.data.message}`)
                            }
                        })
                        .fail(failJson)
                        .always(() => $(this).html('Terminate card'));

                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }

            });
    });
</script>
@endsection
