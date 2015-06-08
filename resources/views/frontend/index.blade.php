@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Welcome to PC-World, Online shopping for Computers and accessories</title>
@stop

@section('breadcrumbs')

@stop

@section('content')
    <div class="container" style="margin-bottom: 84px">
        <div class="wide-banners outer-bottom-vs" data-toggle-animation>
            <div class="row">

                <div class="col-md-12">
                    <div class="wide-banner cnt-strip m-t-40">
                        <div class="image">
                            <img src="{{ asset('assets/images/banners/11.jpg') }}" alt="">
                        </div>
                        <div class="strip">
                            <div class="strip-inner text-right">
                                <h1>one stop place for</h1>

                                <p class="normal-shopping-needs">COMPUTERS, MOBILE PHONES AND MORE</p>
                            </div>
                        </div>
                        <div class="new-label">
                            <div class="text">NEW</div>
                        </div>
                        <!-- /.new-label -->
                    </div>
                    <!-- /.wide-banner -->
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div>
        <section class="section m-b-40" data-toggle-animation>
            <h2 class="section-title">Featured Laptops & Ultrabooks</h2>
            @include('_partials.data.home-page.featured-products', ['data' => $featuredLaptops])
        </section>
        <div class="wide-banners outer-bottom-vs m-t-40" data-toggle-animation>
            <div class="row">

                <div class="col-md-7">
                    <div class="wide-banner cnt-strip">
                        <div class="image">
                            <img class="img-responsive" src="{{ asset('assets/images/banners/1.jpg') }}" alt="">
                        </div>
                        <div class="strip">
                            <div class="strip-inner">
                                <h3 class="hidden-xs">samsung</h3>

                                <h2>galaxy S6</h2>
                            </div>
                        </div>
                    </div>
                    <!-- /.wide-banner -->
                </div>
                <!-- /.col -->

                <div class="col-md-5">
                    <div class="wide-banner cnt-strip">
                        <div class="image">
                            <img class="img-responsive" src="{{ asset('assets/images/banners/2.jpg') }}" alt="">
                        </div>
                        <div class="strip">
                            <div class="strip-inner">
                                <h3 class="hidden-xs">new trend</h3>

                                <h2>smart watches</h2>
                            </div>
                        </div>
                    </div>
                    <!-- /.wide-banner -->
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div>
        <section class="section m-b-40" data-toggle-animation>
            <h2 class="section-title">Top Rated products</h2>
            @include('_partials.data.home-page.top-rated-products')
        </section>
        <hr/>
        <section class="section m-b-40" data-toggle-animation>
            <h2 class="section-title">New products</h2>
            @include('_partials.data.home-page.new-products')
        </section>
    </div>
@stop