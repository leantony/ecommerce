@extends('layouts.backend.master')

@section('header')
    @parent
    <title>New system permission</title>
@stop

@section('content')
    <div class="row admin-form">
        <h2>Add a Permission</h2>
        <hr/>
        {!! Form::open(['route' => 'backend.security.permissions.store']) !!}
        <div class="col-md-6">
            @include('_partials.forms.security.permission')
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Add the permission
                </button>
            </div>

        </div>

        {!! Form::close() !!}
    </div>
@stop