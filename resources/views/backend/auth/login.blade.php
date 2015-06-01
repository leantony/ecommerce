@extends('layouts.shared.auth')

@section('header')
    @parent
    <title>Backend Login</title>
@stop

@section('content')
    <div class="row">
        @include('_partials.forms.authentication.login.backend_login', ['title' => 'Backend', 'displayPasswordHelper' => true, 'useAjax' => false])
    </div>
@stop