@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>PC World&nbsp;&middot;&nbsp;Review Order</title>
@stop

@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true])
@stop

@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')

    <div class="container checkout-wizard">
        <div class="row bs-wizard" style="border-bottom:0;">
            @include('_partials.Checkout.Orders.steps')
        </div>
        <div class="row m-t-20">
            <div class="col-md-12 m-b-20">
                <h1>Your products</h1>

                <p>Review your order below, then press the submit order button when ready</p>
                <hr/>
                <a href="{{ route(!$is_logged_in ? 'checkout.step3' : 'u.checkout.step3') }}">
                    <button class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i>&nbsp;Back to payments page
                    </button>
                </a>
                <hr/>
                @include('_partials.forms.cart.shopping-cart-data', ['includePromoSection' => false, 'useAjax' => true, 'ignoreParentDiv' => true, 'displayOrderSummary' => false])
            </div>
            <div class="col-md-4 col-md-offset-2 pull-right shipping-info">
                @include('_partials.forms.orders.order-summary')
                {!! Form::open(['url' => route($is_logged_in ? 'u.checkout.submitOrder' : 'checkout.submitOrder')]) !!}
                @if(!$is_logged_in & is_null(session('account_created_after_checkout')))

                    <label class='control-label'>Create my account (optional)</label>&nbsp;
                    {!! Form::checkbox('create_account', true, true) !!}
                    <p class="text-info">(Your account will be created before you make your order)</p>
                @endif
                <hr/>
                <button class="btn btn-primary" type="submit">
                    place order
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('brands')

@stop
@section('footer')
    @include('layouts.frontend.sections.footer.footer-basic')
@stop