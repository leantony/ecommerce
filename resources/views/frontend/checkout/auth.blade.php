@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>PC World&nbsp;&middot;&nbsp;Checkout</title>
@stop

@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true, 'altText' => 'Checkout'])
@stop
@section('notification')

@stop
@section('slider')

@stop
@section('content')

    <div class="container">
        <div class="row m-t-10">
            <div class="col-md-12">
                <div class="col-md-5 col-md-offset-1 login">
                    <h2>Returning customers</h2>

                    <p>Sign in to speed up the checkout process and save orders to your account.</p>
                    <hr/>
                    @include('_partials.forms.authentication.login.client_login', ['extra_class' => '', 'display_security_assurance' => false, 'useAjax' => false])
                </div>
                <div class="col-md-5 register">
                    <h2>New Customers</h2>
                    @if(config('site.checkout.allow_guest_checkout', true))
                        <p>Checkout as a guest. We will give you the opportunity to create an account at the end of the
                            checkout process</p>
                        <hr/>
                        <a href="{{ route('checkout.step1', ['allow' => true]) }}">
                            <button class="btn btn-primary btn-lg m-t-5">
                                <i class="fa fa-arrow-right"></i>&nbsp;Checkout as a guest
                            </button>
                        </a>
                    @else
                        <p>Create an Account today. Creating an account is free and allows you to;</p>
                        <hr/>
                        <ul class="lh-20">
                            <li><i class="fa fa-check fa-2x"></i> Conveniently place orders</li>
                            <li><i class="fa fa-check fa-2x"></i> Speed your way through the checkout process</li>
                            <li><i class="fa fa-check fa-2x"></i> Create wish Lists&nbsp;&nbsp;<span
                                        class="label label-info">coming soon!</span>
                            </li>
                            <li><i class="fa fa-check fa-2x"></i> Check the status of your purchases</li>
                        </ul>
                        <hr/>
                        <a href="{{ route('register') }}">
                            <button class="btn btn-primary btn-lg m-t-5">
                                <i class="fa fa-arrow-right"></i>&nbsp;Create my Account
                            </button>
                        </a>
                    @endif
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