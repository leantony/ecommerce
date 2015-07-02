@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Revoke roles from a user</title>
@stop

@section('content')
    <div class="row admin-form">
        <h2>Revoke roles</h2>
        <h6>select a user from the dropdown, and uncheck any of the roles you want to revoke</h6>
        <hr/>
        {!! Form::open(['url' => route('backend.security.access-control.roles.store')]) !!}
        <div class="col-md-6 category">

            <p>{{ $user->present()->fullName }}</p>

            <div class="form-group">
                {!! Form::label('roles', "This user has the following roles. uncheck those you dont want the user to have:", []) !!}
                <br/>
                @foreach($user->roles as $role)
                    {!! Form::checkbox('roles[]', $role->id, true, ['class' => 'form-group']) !!}

                    <span>{{ str_replace('_', ' ', $role->name) }}</span>
                @endforeach
                @if($errors->has('roles'))
                    <span class="wow flash error-msg">{{ $errors->first('roles') }}</span>
                @endif
            </div>

        </div>

        <div class="">
            <a href="#" data-toggle="modal" data-target="#assign">
                <button class="btn btn-success btn-lg">
                    <span class="glyphicon glyphicon-ok-sign"></span> Save
                </button>
            </a>
        </div>

        <div class="modal fade" id="assign" tabindex="-1" role="dialog" aria-labelledby="assign" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                                    class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title text-center">You are adding permissions to a role</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info"><span class="glyphicon glyphicon-question-sign"></span>
                            Are you sure you want to do this?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- submit button -->
                        <div class="pull-left">
                            <a href="#">
                                <button class="btn btn-success" type="submit">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Yes
                                </button>
                            </a>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <span class="glyphicon glyphicon-stop"></span> No
                            </button>
                        </div>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        {!! Form::close() !!}
    </div>
@stop