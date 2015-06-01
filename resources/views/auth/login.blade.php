@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Login &middot; Register</title>
@stop
@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true, 'altText' => 'Authentication'])
@stop
@section('slider')
@stop
@section('notification')

@stop
@section('content')
    <div class="container-fluid">
        <div class="row authentication">
            <div class="col-md-4 col-md-offset-1">
                <div class="m-t-20">
                    @include('_partials.forms.authentication.login.client_login', ['heading' => true, 'extra_class' => 'btn-block', 'useAjax' => false])
                </div>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <h3>Or, Sign up today</h3>
                <hr/>
                <p>Creating an account is free and allows you to;</p>
                <ul class="lh-20">
                    <li><i class="fa fa-check fa-2x"></i> Conveniently place orders</li>
                    <li><i class="fa fa-check fa-2x"></i> Speed your way through the checkout process</li>
                    <li><i class="fa fa-check fa-2x"></i> Create wish Lists&nbsp;&nbsp;<span class="label label-info">coming soon!</span>
                    </li>
                    <li><i class="fa fa-check fa-2x"></i> Check the status of your purchases</li>
                </ul>
                <hr/>
                <a href="{{ link_to_secure_route('register') }}">
                    <button class="btn btn-primary">
                        Create my Account&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
@stop

@section('brands')
@stop