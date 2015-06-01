@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Create User</title>
@stop

@section('content')

    <div class="row admin-form">
        <h4>Add a new User</h4>
        <hr/>
        <div class="msgDisplay m-t-10"></div>
        {!! Form::open(['route' => 'backend.users.store', 'id' => 'registrationForm']) !!}
        <input type="hidden" name="accept" value="true">
        @include('_partials.forms.users.users_form', ['passwords' => true])
        <div class="row">
            <div class="col-md-6">
                <div class="pull-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok-sign"></span> Add the user
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@stop
