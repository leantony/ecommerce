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
            @include('_partials.Checkout.Orders.steps')
        </div>
        <hr/>
        <div class="row" id="step-3">
            <div class="col-md-12">
                <h3>We promised to create an account for you. Complete this step to create your account</h3>
                <hr/>
                <div class="col-md-6 m-b-10">
                    <div class="row shipping-info">

                        <div class="alert alert-info">
                            <h4>You only need to enter your password.</h4>
                        </div>
                        {!! Form::open(['url' => route('checkout.createAccount'), 'id' => 'guestCreateAccount']) !!}
                        <div class="form-group">
                            {!! Form::label('password', "Password:", []) !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter your password']) !!}
                            @if($errors->has('password'))
                                <span class="wow flash error-msg">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('password_confirmation', "Password confirmation:", []) !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'repeat your password']) !!}
                            @if($errors->has('password_confirmation'))
                                <span class="wow flash error-msg">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="field-row form-group">
                            <input type="checkbox" name="accept">

                            <span>I agree to the <a href="{{ route('terms') }}" target="_blank">Terms and conditions</a> </span>
                            <br/>
                            @if($errors->has('accept'))
                                <span class="wow flash error-msg">{{ $errors->first('accept') }}</span>
                            @endif
                        </div>
                        <hr/>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">
                                Create my Account
                            </button>
                        </div>
                        {!! Form::close() !!}
                        <hr/>
                        <div class="col-md-12">
                            <a href="{{ route('checkout.step4') }}">
                                <button class="btn btn-warning pull-left">
                                    <i class="fa fa-arrow-left"></i>&nbsp;Back to orders page
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