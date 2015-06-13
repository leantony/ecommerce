@extends('layouts.backend.master')

@section('header')
    @parent
    <title>PC-World Admin - Welcome</title>
@stop

@section('breadcrumbs')

@stop
@section('content')

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Dashboard
            </h1>
            <hr/>
            <h4>
                Welcome {{ $auth_user->present()->fullName }}
            </h4>

            <p>From the backend, you can configure most aspects of the system. You can add products, users, categories,
                and much more</p>

            <p>Use the navigation bar above <i class="fa fa-arrow-up"></i> , to navigate to various configuration
                options</p>
            <hr/>
            <p>Or if you simply want to access the site's frontend, you can do
                so {!! link_to_route('home', 'here', [], ['target' => '_blank']) !!}</p>
        </div>
    </div>
    <!-- /.row -->
    <br/>
    <hr/>
@stop