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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Virtual cards</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <form id="virtual_card_form" method="POST" action="{{ route('create-card') }}">
                        @csrf
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="name">Card currency</label>
                                        <select name="currency" class="form-control" id="currency">
                                            <option value="NGN" selected>NGN</option>
                                            <option value="USD" >USD</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="author">Amount</label>
                                        <input type="number" min="100" name="amount" value="100" id="amount"
                                            class="form-control" />

                                    </div>
                                </div>

                            </div>


                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="price">Billing name</label>
                                        <input type="text" name="billing_name" placeholder="" id="billing_name"
                                            class="form-control" />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="price">Billing address</label>
                                        <input type="text" name="billing_address" id="billing_address"
                                            class="form-control" />

                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="price">Billing city</label>
                                        <input type="text" name="billing_city" id="billing_city" class="form-control" />

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="price">Billing postal code</label>
                                        <input type="text" name="billing_postal_code" id="billing_postal_code"
                                            class="form-control" />

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="biling_country">Billing country</label>
                                      
                                            <select  name="billing_country" id="billing_country"
                                            class="form-control">
                                        <option value="NG" selected>NG</option>
                                        <option value="GH">GH</option>
                                        <option value="KE">KE</option>
                                        <option value="ZA">ZA</option>
                                        <option value="TZ">TZ</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="price">Billing state</label>
                                        <input type="text" name="billing_state" id="billing_state" class="form-control" />

                                    </div>
                                </div>
                            </div>





                            <div class="form-group">
                                <button class="btn btn-primary btn-lg" id="create">Create card </button>
                            </div>
                        </div>
                    </form>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

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

                  var fd = new FormData();
                
              const myForm = $('form#virtual_card_form');
                //get other data inside the form
                var other_data = myForm.serializeArray();
                
                $.each(other_data, function(key, input) {
                    fd.append(input.name, input.value);
                });
                
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
                                    data: fd,
                                    type: 'POST',
                                    contentType: false,
                                    processData: false,
                                })
                                .done((response) => {
                                    //let receiever = response.data.receiver;
                                    if(response.request.status == 'success'){
                                  successNoty(
                                        `Card for ${response.data.billing_name} was created successfully`
                                    );
                                    myForm.trigger("reset");
                                    //$('#content-container').load(`${location.href} #content-container`);
                                    }else{
                                        errorDisplay(response.request.message);
                                    }
                                  
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

    </script>
@endsection
