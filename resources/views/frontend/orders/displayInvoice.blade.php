@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>PC World&nbsp;&middot;&nbsp;View Invoice {{ $order->id }}</title>
@stop

@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true])
@stop

@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')
    <div class="container-fluid">
        <div class="m-t-20 m-b-20 printable">
            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    @include('_partials.forms.invoice.header')
                    <div class="row">
                        @include('_partials.forms.invoice.was_billed_to', ['user' => $user])
                        @include('_partials.forms.invoice.was_shipped_to', ['user' => $user])
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-xs-6">
                            <address>
                                <strong>Payment Method:</strong><br>

                                <p class="text text-info">#This is a test invoice. You did not pay for the product</p>
                                <br>
                            </address>
                        </div>
                        <div class="col-xs-6 text-right">
                            <address>
                                <strong>Order Date:</strong><br>
                                {{ $order->created_at }}<br><br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @include('_partials.forms.invoice.products_table', ['orderHasArrived' => $order->delivered, 'order' => $order, 'products_' => $order->data['products'], 'basket' => $order->data['cart']])
            </div>
        </div>
        <hr/>
        <div class="col-md-12 m-t-30 m-b-40 non-printable">
            <div class="col-md-4">
                <a href="{{ route('help.article.view', ['article' => 8, 'popup' => true]) }}" data-help>
                    I don't understand this information
                </a>
            </div>
            <div class="col-md-4">
                <a href="javascript:" data-print-content>
                    <button class="btn btn-primary">
                        <i class="glyphicon glyphicon-print"></i>&nbsp;Print this invoice
                    </button>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ auth()->check() ? route('u.order.finished') : route('order.finished') }}"
                   data-confirm="Clicking this button would empty your shopping cart, and take you back to the home page. You will still be able to view this order, by visiting https://myapp.com/myorders. Continue?">
                    <button class="btn btn-primary">
                        <i class="fa fa-cart-arrow-down"></i>&nbsp;Continue shopping
                    </button>
                </a>
            </div>

        </div>
    </div>
@stop

@section('brands')

@stop
@section('footer')
    @include('layouts.frontend.sections.footer.footer-basic')
@stop