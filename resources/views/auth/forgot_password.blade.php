@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Forgot password</title>
@stop

@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true, 'altText' => 'Forgot password'])
@stop

@section('slider')

@stop

@section('content')

    <div class="container-fluid">
        <div class="row authentication">
            <div class="col-md-4 col-md-offset-2 col-sm-8 col-xs-12">
                @include('_partials.forms.authentication.reset_pass', ['useAjax' => true])
                <hr/>
                <a href="{{ route('login') }}">
                    Cancel
                </a>
            </div>
        </div>
    </div>
@stop

@section('brands')

@stop