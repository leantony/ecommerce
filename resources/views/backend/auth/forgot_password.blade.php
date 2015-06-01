@extends('layouts.shared.auth')

@section('head')
    @parent
    <title>Forgot password</title>
@stop

@section('content')

    <div class="container-fluid">

        <div class="col-md-4 col-md-offset-4 login">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Reset Password</h3>
                </div>
                <div class="panel-body">
                    @include('_partials.forms.authentication.reset_pass', ['useAjax' => true])
                    <hr/>
                    <a href="{{ route('backend.login') }}">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('brands')

@stop