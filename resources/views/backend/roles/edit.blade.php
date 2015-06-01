@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Edit System Roles</title>
@stop

@section('content')
    <div class="row admin-form">
        <h2>Modify a system role</h2>

        <div class="col-md-12" style="margin-bottom: 20px;">
            <div class="pull-left">
                <a href="{{ url(URL::previous()) }}">
                    <button class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i>
                        &nbsp;Back
                    </button>
                </a>
            </div>
        </div>
        {!! Form::model($role,['route' => ['backend.security.roles.update', 'id' => $role->id], 'method' => 'PATCH']) !!}
        <div class="col-md-6">
            @include('_partials.forms.security.roles')
            <div class="form-group">
                {!! Form::label('date_created', "Date the role was created:", []) !!}
                <p>{{ $role->created_at }}</p>
            </div>
            <div class="form-group">
                {!! Form::label('date_updated', "Date the role was last updated:", []) !!}
                <p>{{ $role->updated_at }}</p>
            </div>
            <hr/>
            <div class="pull-left">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Finish edit
                </button>
            </div>
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#deleteRole">
                    <button class="btn btn-danger" data-title="Delete" disabled>
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteRole', 'route' => route('backend.security.roles.destroy', ['id' => $role->id])])
@stop