@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Registration</title>
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
        <div class="row authentication ">
            <div class="auth-container">
                <div class="col-md-5 col-md-offset-1">
                    <h5>Take a few minutes to create an account now. Your information will safely be secured with us to
                        save you time, next time.</h5>
                    <hr/>
                    @include('_partials.forms.authentication.registration.client_registration', ['useAjax' => true])
                </div>

            </div>
        </div>
    </div>
@stop

@section('brands')

@stop