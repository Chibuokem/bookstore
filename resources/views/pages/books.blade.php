<!DOCTYPE html>
<html lang="en">
@include('includes/head')
<body>
  @include('includes/header')
    <div class="breadcrumb">
        <div class="container">
        <a class="breadcrumb-item" href="{{route('homepage')}}">Home</a>
            <span class="breadcrumb-item active">Books</span>
        </div>
    </div>
    <section class="static about-sec">
        <div class="container">
            <h2>Books</h2>
            <div class="recomended-sec">
                <div class="row">
                      @foreach($books as $book)
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                        <img src="{{asset('storage/'.$book->image)}}" alt="img">
                        <h3>{{$book->name}}</h3>
                        <h6><span class="price">₦{{$book->price}}</span> / <a href="{{ route('book', ['book' => $book->id ]) }}">Buy Now</a></h6>
                            <div class="hover">
                            <a href="{{ route('book', ['book' => $book->id ]) }}">
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
               @endforeach 
                    {{-- <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img1.jpg" alt="img">
                            <h3>how to be a bwase</h3>
                            <h6><span class="price">$49</span> / <a href="#">Buy Now</a></h6>
                            <div class="hover">
                                <a href="product-single.html">
                            <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </a>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img2.jpg" alt="img">
                            <h3>How to write a book...</h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                            <span class="sale">Sale !</span>
                            <div class="hover">
                                <a href="product-single.html">
                            <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </a>
                            </div>
                        </div>
                    </div> --}}
                   
                    {{-- <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img3.jpg" alt="img">
                            <h3>7-day self publish...</h3>
                            <h6><span class="price">$49</span> / <a href="#">Buy Now</a></h6>
                            <div class="hover">
                                <a href="product-single.html">
                            <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <img src="images/img4.jpg" alt="img">
                            <h3>wendy doniger</h3>
                            <h6><span class="price">$49</span> / <a href="#">Buy Now</a></h6>
                            <div class="hover">
                                <a href="product-single.html">
                            <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            {{-- <h2>recently added books to our store</h2>
            <div class="recent-book-sec">
                <div class="row">
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r1.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r2.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r3.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r4.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r5.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r1.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r2.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r3.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r4.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r5.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r1.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r2.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r3.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r4.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r5.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r1.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r2.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r3.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r4.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="item">
                            <img src="images/r5.jpg" alt="img">
                            <h3><a href="#">Keepers of the kalachakara</a></h3>
                            <h6><span class="price">$19</span> / <a href="#">Buy Now</a></h6>
                        </div>
                    </div>
                </div>
                <div class="btn-sec">
                    <a href="products.html" class="btn gray-btn">load More books</a>
                </div>
            </div> --}}
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="address">
                        <h4>Our Address</h4>
                        <h6>The BookStore Theme, 4th Store
                        Beside that building, USA</h6>
                        <h6>Call : 800 1234 5678</h6>
                        <h6>Email : info@bookstore.com</h6>
                    </div>
                    <div class="timing">
                        <h4>Timing</h4>
                        <h6>Mon - Fri: 7am - 10pm</h6>
                        <h6>​​Saturday: 8am - 10pm</h6>
                        <h6>​Sunday: 8am - 11pm</h6>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="navigation">
                        <h4>Navigation</h4>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="terms-conditions.html">Terms</a></li>
                            <li><a href="products.html">Products</a></li>
                        </ul>
                    </div>
                    <div class="navigation">
                        <h4>Help</h4>
                        <ul>
                            <li><a href="#">Shipping & Returns</a></li>
                            <li><a href="privacy-policy.html">Privacy</a></li>
                            <li><a href="#">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form">
                        <h3>Quick Contact us</h3>
                        <h6>We are now offering some good discount 
                            on selected books go and shop them</h6>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <input placeholder="Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-12">
                                    <textarea placeholder="Messege"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn black">Alright, Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>(C) 2017. All Rights Reserved. BookStore Wordpress Theme</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="share align-middle">
                            <span class="fb"><i class="fa fa-facebook-official"></i></span>
                            <span class="instagram"><i class="fa fa-instagram"></i></span>
                            <span class="twitter"><i class="fa fa-twitter"></i></span>
                            <span class="pinterest"><i class="fa fa-pinterest"></i></span>
                            <span class="google"><i class="fa fa-google-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>