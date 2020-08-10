           <div class="card" style="margin-top:20px;" id="payment-div">
              <div class="card-body">
                <h5 class="card-title">Order Summary</h5>

                <p class="card-text">
                  Name of book : {{$book->name}}
                </p>
                 <p class="card-text">
                  Amount : ₦{{$book->price}}
                </p>

                <p class="card-text">
                  Email : {{$email}}
                </p>
                <p class="card-text">
                  Phone Number : {{$phone}}
                </p>
                 <p class="card-text">
                    Order reference : {{$reference}}
                </p>
              <form id="order-form" action="{{route('store-order')}}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{$book->id}}"/>
                <input type="hidden" name="reference" id="reference" value="{{$reference}}"/>
                <input type="hidden" name="email" id="email" value="{{$email}}"/>
                 <input type="hidden" name="name" id="name" value="{{$name}}"/>
                 <input type="hidden" name="quantity" id="quantity" value="{{$quantity}}"/>
                 <input type="hidden" name="amount" id="amount" value="{{$book->price}}"/>
                
                </form>
                {{-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> --}}
                <button id="pay" class="btn btn-primary">Pay</button>
              </div>
            </div>
            {{-- <script src="https://checkout.flutterwave.com/v3.js"></script> --}}
            <script src="https://ravemodal-dev.herokuapp.com/v3.js"></script>
            <script>

  function makePayment() {
    FlutterwaveCheckout({
      public_key: "{{$rave_public_key}}",
      tx_ref: "{{$reference}}",
      amount: "{{$book->price}}",
      currency: "NGN",
      payment_options: "card,mobilemoney,ussd",
      customer: {
        email: "{{$email}}",
        phonenumber: "{{$phone}}",
        name: "{{$name}}",
      },
      callback: function (data) { // specified callback function
        console.log(data);
        //verification starts here
      var amount = data.amount;
      var reference = data.tx_ref;
      var status = data.status;
      var transaction_id = data.transaction_id;
      var fd = new FormData();
      fd.append('amount', amount);
      fd.append('reference', reference);
      fd.append('status', status);
      fd.append('transaction_id', transaction_id);
      fd.append('_token', "{{ csrf_token() }}");
      //console.log(fd);
       $('#pay').html('Confirming...');
                    $.ajax({
                            url: '{{route('confirm-payment')}}',
                            data: fd,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                        })
                        .done((response) => {
                            if(response.status == 1){
                              successNoty(`Payment for ${response.data.book.name} was successful`);
                            }

                        })
                        .fail(failJson)
                        .always(() => {
                          $('#pay').html('Pay');
                          document.getElementById('pay').disabled = false;
                        });
        //verification ends here 
      },
      customizations: {
        title: "My book store",
        description: "Payment for book titled {{$book->name}}",
        logo: "https://assets.piedpiper.com/logo.png",
      },
    });
  }

  $(document).on('click', '#pay', function(e) {
         e.preventDefault();
         //disable button
        var fd = new FormData();
        const myForm = $('form#order-form');
        //get other data inside the form
        var other_data = myForm.serializeArray();
          
        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });
        document.getElementById('pay').disabled = true;
       $('#pay').html('Sending...');
                    $.ajax({
                            url: myForm.attr('action'),
                            data: fd,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                        })
                        .done((response) => {
                            makePayment();

                        })
                        .fail(failJson)
                        .always(() => {
                          $('#pay').html('Pay');
                          document.getElementById('pay').disabled = false;
                        });
        
            })
            
</script>