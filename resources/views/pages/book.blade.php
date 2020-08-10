<!DOCTYPE html>
<html lang="en">
@include('includes/head')
<body>
  @include('includes/header')
    <div class="breadcrumb">
        <div class="container">
        <a class="breadcrumb-item" href="{{route('homepage')}}">Home</a>
        <span class="breadcrumb-item active">{{$book->name}}</span>
        </div>
    </div>
    <section class="product-sec">
        <div class="container">
        <h1>{{$book->name}}</h1>
            <div class="row">
                <div class="col-md-6 slider-sec">
                    <!-- main slider carousel -->
                    <div id="myCarousel" class="carousel slide">
                        <!-- main slider carousel items -->
                        <div class="carousel-inner">
                            <div class="active item carousel-item" data-slide-number="0">
                            <img src="{{asset('storage/'.$book->image)}}" class="img-fluid">
                            </div>
                            <div class="item carousel-item" data-slide-number="1">
                                <img src="images/product2.jpg" class="img-fluid">
                            </div>
                            <div class="item carousel-item" data-slide-number="2">
                                <img src="images/product3.jpg" class="img-fluid">
                            </div>
                        </div>
                        <!-- main slider carousel nav controls -->
                        <ul class="carousel-indicators list-inline">
                            <li class="list-inline-item active">
                                <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#myCarousel">
                                <img src="{{asset('storage/'.$book->image)}}" class="img-fluid">
                            </a>
                            </li>
                            {{-- <li class="list-inline-item">
                                <a id="carousel-selector-1" data-slide-to="1" data-target="#myCarousel">
                                <img src="images/product2.jpg" class="img-fluid">
                            </a>
                            </li>
                            <li class="list-inline-item">
                                <a id="carousel-selector-2" data-slide-to="2" data-target="#myCarousel">
                                <img src="images/product3.jpg" class="img-fluid">
                            </a> --}}
                            </li>
                        </ul>
                    </div>
                    <!--/main slider carousel-->
                </div>
                <div class="col-md-6 slider-content">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's printer took a galley of type and Scrambled it to make a type and typesetting industry. Lorem Ipsum has been the book. </p>
                    <p>t has survived not only fiveLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's printer took a galley of type and</p>
                    <ul>
                        {{-- <li>
                            <span class="name">Digital List Price</span><span class="clm">:</span>
                        <span class="price">₦{{$book->price}}</span>
                        </li>
                        <li>
                            <span class="name">Print List Price</span><span class="clm">:</span>
                            <span class="price">$10.99</span>
                        </li> --}}
                        <li>
                            <span class="name">Kindle Price</span><span class="clm">:</span>
                            <span class="price final">₦{{$book->price}}</span>
                        </li>
                        {{-- <li><span class="save-cost">Save $7.62 (69%)</span></li> --}}
                    </ul>
                    <div class="btn-sec">
                        {{-- <button class="btn ">Add To cart</button> --}}
                        <button class="btn black" id="buy-book">Buy Now</button>
                    </div>
                </div>
            </div>
            <div class="row" id="summary-div">
                
            </div>
        </div>
    </section>
    {{-- <section class="related-books">
        <div class="container">
            <h2>You may also like these book</h2>
            <div class="recomended-sec">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img1.jpg" alt="img">
                            <h3>how to be a bwase</h3>
                            <h6><span class="price">$49</span> / <a href="#">Buy Now</a></h6>
                            <div class="hover">
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img2.jpg" alt="img">
                            <h3>How to write a book...</h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                            <span class="sale">Sale !</span>
                            <div class="hover">
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img3.jpg" alt="img">
                            <h3>7-day self publish...</h3>
                            <h6><span class="price">$49</span> / <a href="#">Buy Now</a></h6>
                            <div class="hover">
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img4.jpg" alt="img">
                            <h3>wendy doniger</h3>
                            <h6><span class="price">$49</span> / <a href="#">Buy Now</a></h6>
                            <div class="hover">
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
     @include('includes/footer')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/custom2.js')}}"></script>
    <script>
        $(document).on('click', '#continue', function(e) {
         e.preventDefault();
        let name = $("#customer_name").val();
        let email = $("#customer_email").val();
        let price = $("#customer_phone").val();
        if(name == ""){
          errorDisplay("Please enter your name");
          return;
        }

        if(email == ""){
          errorDisplay("Please enter your email");
          return;
        }

        var fd = new FormData();
        // var files = $('#image_update')[0].files[0];
        // fd.append('image', files);
        const myForm = $('form#buy-book-form');
        //get other data inside the form
        var other_data = myForm.serializeArray();
          
        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });
         swal({
                title: "Are you sure you sure your record is correct and your ready to procced?",
                text: "Entering a wrong record could mean not getting value for your payment",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $('#continue').html('Sending...');
                    $.ajax({
                            url: myForm.attr('action'),
                            data: fd,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                        })
                        .done((response) => {
                            // successNoty(`Book was updated successfully`);
                            //$('#content-container').load(`${location.href} #content-container`);
                            $("#summary-div").html(`<div class="col-md-12">${response}</div>`);
                            
                            window.scrollBy(0, 130);
                            //hide modal
                             $('#emptyModal').modal('hide');
                        })
                        .fail(failJson)
                        .always(() => $('#upload').html('Continue'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });
        
    })

$(document).on('click', '#buy-book', function(e) {
    e.preventDefault();

    $(this).html('loading ...');
    $('#emptyModal').modal('show');
    $('#_empty_modal_content').html('loading ...');

    buyBook();
    
});

const buyBook = () => {

    const form = $('#_empty_modal_content');
    form.html('');
    form.append(`
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Buy {{$book->name}}</h3>
            </div>
    <div class="card-body">
    <form id="buy-book-form" action="{{route('order-summary')}}">@csrf <div class="card-body">
              <input type="hidden" name="book_id" value="{{$book->id}}"/>
              
             <div class="form-group">
                  <label for="question">Your Name</label>
                <input name="customer_name" class="form-control"  id="customer_name"/>        
              </div>

              <div class="form-group">
                 <label for="type">Your email address</label>
                <input type="email" name="customer_email" class="form-control"  id="customer_email"/>
              
              </div> 
              
              <div class="form-group">
                 <label for="type">Your Phone Number</label>
                <input type="text" name="customer_phone" class="form-control" id="customer_phone"/>        
              </div>
              <input type="hidden" name="quantity" value="1"/>
              
             
              <div class="form-group">
                <button class="btn btn-primary btn-lg" id="continue">Continue</button>
              </div>
            </div>
          </form>
     </div>
    </div>       
    `);
};
    </script>
</body>

</html>