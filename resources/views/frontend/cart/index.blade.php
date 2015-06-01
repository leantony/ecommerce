@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Empty Shopping cart</title>
@stop

@section('slider')

@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 wow bounce">
                <div class="empty-cart-message alert alert-info">
                    <h1>Your Shopping cart is currently Empty</h1>
                </div>
            </div>
        </div>
        <div class="row m-b-40 ">
            <div class="col-md-8">
                <h3>
                    Find products by by searching for them, or by viewing some we've provided for you below
                </h3>

                <h5>You can also <a href="#brands-carousel">shop for products by brand</a>,
                    or {!! link_to_route('home', 'visit the homepage') !!}</h5>
                <hr/>
                <p>If you have an account, {!! link_to_route('login', 'Sign In') !!} to view your cart</p>
            </div>

        </div>
    </div>
@stop