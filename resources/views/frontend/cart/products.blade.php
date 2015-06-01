@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>View Shopping cart</title>
@stop

@section('slider')

@stop

@section('content')
    <div class="container">
        <div class="row m-b-20 ">
            <h1>Your Shopping cart
                <span class="text text-info text-small">[{{ array_get($cart['cart'], 'total_products') > 1 ? array_get($cart['cart'], 'total_products') .' '. str_plural('item') : array_get($cart['cart'], 'total_products') .' '. str_singular('items') }}
                    ]</span>
            </h1>
            <hr/>
            <div class="col-md-4">
                {!! Form::open(['url' => route('cart.removeAllProducts'), 'method' => 'DELETE', 'data-remote']) !!}
                <button class="btn btn-warning p-all-10" type="submit" data-confirm="Are you sure you want to do this?">
                    <i class="fa fa-trash"></i>&nbsp;Empty cart
                </button>
                {!! Form::close() !!}

            </div>
            @include('_partials.Checkout.displayCheckoutButton', ['offset' => 4])
            @include('_partials.forms.cart.shopping-cart-data', ['includePromoSection' => true, 'useAjax' => true, 'ignoreParentDiv' => false, 'displayOrderSummary' => true])
        </div>
        <hr/>
        @include('_partials.Checkout.displayCheckoutButton')
        <h2>View more products below</h2>
        <section class="section m-b-20 ">
            <h2 class="section-title">Featured Tablets</h2>

            @include('_partials.data.home-page.featured-products', ['data' => $featuredTablets])
        </section>
    </div>
@stop