<footer class="main-footer" data-toggle-animation>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3>Products</h3>
                    <ul>
                        @foreach($categories as $category)

                            <li>
                                <a href="{{ route('categories.shop', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>

                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> My Account</h3>
                    <ul>
                        <li><a href="{{ route('myaccount') }}"> Account Home</a></li>
                        <li><a href="{{ route('mycart') }}"> My Shopping cart </a></li>
                        <li><a href="{{ route('myorders') }}"> My Orders </a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> help & support</h3>
                    <ul>
                        <li><a href="{{ route('help') }}">Help page</a></li>
                        <li><a href="{{ route('faq') }}">Frequently Asked Questions</a></li>
                        <li><a href="#">Contact Support</a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Company </h3>
                    <ul>
                        <li><a href="#">News</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact us</a></li>
                        <li><a href="{{ route('terms') }}">Agreement policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                    <h3> News Letter </h3>

                    <p>Sign up for our newsletter</p>
                    <ul>
                        <li>
                            <form method="POST" accept-charset="UTF-8" action="#" data-disable-submission>
                                {!! Form::token() !!}
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="Enter your email" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Subscribe</button>
                            </form>
                        </li>
                    </ul>
                    <hr/>
                    <ul class="social">
                        <li><a href="#"> <i class=" fa fa-facebook"> </i> </a></li>
                        <li><a href="#"> <i class="fa fa-twitter"> </i> </a></li>
                        <li><a href="#"> <i class="fa fa-google-plus"> </i> </a></li>
                        <li><a href="#"> <i class="fa fa-pinterest"> </i> </a></li>
                        <li><a href="#"> <i class="fa fa-youtube"> </i> </a></li>
                    </ul>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!--/.footer-->

    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> Copyright &copy; PC-World {{ date('Y') }}. All right reserved. </p>

            <div class="pull-right">
                <ul class="nav nav-pills payments">
                    <li><i class="fa fa-cc-visa"></i></li>
                    <li><i class="fa fa-cc-mastercard"></i></li>
                    <li><i class="fa fa-cc-amex"></i></li>
                    <li><i class="fa fa-cc-paypal"></i></li>
                </ul>
            </div>
        </div>
    </div>

</footer>