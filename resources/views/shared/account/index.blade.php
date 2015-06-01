@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Your Account</title>
@stop

@section('slider')

@stop

@section('content')
    <div class="container m-b-40 m-t-20">
        <div class="row user-account  ">
            <div class="col-md-6 col-md-offset-3 p-all-10 account-info">

                @include('_partials.data.account.personal-info')
                <hr/>
                @include('_partials.data.account.contact-info')
                <hr/>
                @include('_partials.data.account.shipping-info')
                <hr/>
                @include('_partials.data.account.orders-info')
                <hr/>
                @include('_partials.data.account.security-info')
                <hr/>
                @include('_partials.data.account.delete-account')

            </div>

        </div>
    </div>

@stop

@section('brands')

@stop
