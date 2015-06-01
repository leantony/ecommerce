@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>PC World&nbsp;&middot;&nbsp;Checkout</title>
@stop

@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true, 'altText' => 'Checkout'])
@stop

@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')
    <div class="container checkout-wizard  ">
        <div class="row bs-wizard" style="border-bottom:0;">
            @include('_partials.Checkout.payment.steps')
        </div>
        <hr/>
        <div class="row" id="step-3">
            <div class="col-md-12">
                <h3>Payment information</h3>

                <div class="col-md-6 m-b-10">
                    <div class="row shipping-info">

                        <div class="alert alert-info">
                            <h4>Payment:</h4>

                            <p>Use any of the payment methods below</p>
                        </div>
                        <p class="text text-info">(press any of the described buttons to pull down a payment form)</p>
                        <button class="btn btn-success" type="button" data-toggle="collapse"
                                data-target="#paymentReward" aria-expanded="false" aria-controls="paymentReward">
                            Redeem promo code / voucher
                        </button>
                        <div class="collapse m-t-10" id="paymentReward">

                            <p>Have a voucher or promo code? redeem them here.</p>
                            @include('_partials.Checkout.payment.redeem-promo', ['voucher' => true])
                        </div>
                        <hr/>
                        <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#paymentMPESA"
                                aria-expanded="false" aria-controls="paymentMPESA">
                            Pay via M-PESA
                        </button>
                        <div class="collapse m-t-10" id="paymentMPESA">
                            <div class="well">
                                <p>This Feature has not been implemented yet. Sorry for the inconvenience.</p>

                                <p>You can use the other methods of payment we've provided</p>
                            </div>
                        </div>
                        <hr/>
                        <div class="alert alert-info">
                            <h4>Pay with Credit/Debit Card</h4>
                        </div>
                        <p>Enter your credit card Information</p>

                        <div class="row">
                            <div class="m-t-10 col-md-12" id="paymentVisa">
                                @include('_partials.Checkout.payment.credit-card', ['route' => $is_logged_in ? route('u.checkout.step3.post') : route('checkout.step3.post'), 'hideSubmitButton' => true, 'secondRoute' => $is_logged_in ? route('u.checkout.step4') : route('checkout.step4')])
                            </div>
                        </div>
                        <hr/>
                        <div class="col-md-12">
                            <a href="{{ $is_logged_in ? route('u.checkout.step2') : route('checkout.step2') }}">
                                <button class="btn btn-warning pull-left">
                                    <i class="fa fa-arrow-left"></i>&nbsp;Back to shipping page
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-2 pull-right shipping-info">
                    @include('_partials.forms.orders.order-summary')
                </div>
            </div>

        </div>
    </div>
@stop
@section('brands')

@stop
@section('footer')
    @include('layouts.frontend.sections.footer.footer-basic')
@stop