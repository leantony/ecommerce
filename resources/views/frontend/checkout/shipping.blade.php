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
    <div class="container checkout-wizard">
        @if($is_logged_in)
            @include('_partials.modals.account.editShippingInfo', ['elementID' => 'shippingInfoModal', 'route' => 'u.checkout.step2.patch', 'fromCheckout' => true])
        @else
            @include('_partials.modals.Checkout.editGuestInfo', ['elementID' => 'shippingInfoModal'])
        @endif

        <div class="row bs-wizard" style="border-bottom:0;">
            @include('_partials.Checkout.Shipping.steps')
        </div>
        <hr/>
        <div class="row" id="step-2">
            <div class="col-md-12">
                <h3>Shipping information</h3>

                <div class="col-md-6 m-b-10">
                    <div class="row shipping-info">
                        <div class="alert alert-info">
                            <h4>Ship Items to:</h4>
                        </div>
                        @include('_partials.Checkout.Shipping.user-info', ['data' => $is_logged_in ? $user : $guest])
                        <button class="btn btn-primary" data-toggle="modal" data-target="#shippingInfoModal">
                            <i class="fa fa-edit"></i>&nbsp;Edit this information
                        </button>
                        <hr/>
                        <div class="alert alert-info">
                            <h4>Your Item(s):</h4>
                        </div>

                        <p><i class="fa fa-info-circle checkout-info"></i>&nbsp;You will get an opportunity to modify
                            your products, at the Order page</p>


                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="bold">Product Name</th>
                                <th class="bold">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart['products'] as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>


                        <hr/>
                        <div class="alert alert-info">
                            <h4>Shipping method:</h4>
                        </div>
                        @include('_partials.Checkout.Shipping.shipping-method', ['data' => $is_logged_in ? $user : $guest])
                        <hr/>
                        <div class="alert alert-info">
                            <h4>Product delivery:</h4>
                        </div>
                        @include('_partials.Checkout.Shipping.delivery', ['data' => $is_logged_in ? $user : $guest])
                        <hr/>
                        @include('_partials.Checkout.Shipping.buttons')
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