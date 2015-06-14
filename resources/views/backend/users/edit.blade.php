@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Update User</title>
@stop

@section('content')
    <div class="row admin-form">
        <div class="col-md-12">
            <h4>Updating {{ beautify($user->present()->fullName) }}</h4>
            <hr/>
            <div class="col-md-6">
                <div class="pull-right">
                    <a href="#">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#editPassword"><i
                                    class="fa fa-edit"></i>&nbsp;Edit password
                        </button>
                    </a>
                </div>
            </div>
            <br/>

            <div class="msgDisplay m-t-30"></div>
        </div>

        {!! Form::model($user, ['url' => route('backend.users.update', ['user' => $user->id]), 'method' => 'PATCH']) !!}

        <div class="col-xs-10">
            <p class="form-control-static"><b>Created on:</b> <span class="text-info">{{ $user->created_at }}</span>
                <b>Last Updated on:</b> <span class="text-info">{{ $user->updated_at }}</span></p>
        </div>
        <div class="col-md-12">
            <p>Role(s): {{ $user->roles->count() == 0 ? "None" : $user->roles->implode('name') }}</p>
        </div>

        <hr/>
        <div class="col-md-6">
            @include('_partials.forms.users.users_form')

            <div class="pull-right">
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Save new details
                    </button>
                </div>
            </div>
            <div class="pull-left">
                <a href="#" data-toggle="modal" data-target="#deleteUser">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>

            </div>

        </div>
        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteUser', 'route' => route('backend.users.destroy', ['user' => $user->id]) ])
    @include('_partials.modals.account.editPassword', ['elementID' => 'editPassword', 'route' => route('useraccount.password.edit', ['user_id' => $user->id])])
@stop
