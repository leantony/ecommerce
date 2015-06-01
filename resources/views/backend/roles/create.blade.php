@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Create a new system role</title>
@stop

@section('content')
    <div class="row admin-form">
        <h2>Add a new role</h2>
        <hr/>
        {!! Form::open(['route' => 'backend.security.roles.store']) !!}
        <div class="col-md-6">
            @include('_partials.forms.security.roles')
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Add the role
                </button>
            </div>

        </div>

        {!! Form::close() !!}
    </div>
@stop