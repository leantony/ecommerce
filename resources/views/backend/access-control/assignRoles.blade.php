@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Assign users a role</title>
@stop

@section('content')

    <div class="row admin-form">
        <div class="col-md-6 category">
            <h2>Roles Assignment</h2>
            <h6>Select a user, and the roles you wish to assign to them</h6>
            <hr/>
            {!! Form::open(['url' => route('backend.security.access-control.roles.store')]) !!}
            <div class="form-group">
                {!! Form::label('user_id', "Select a user. For multiple users, you'll need to repeat this procedure:", []) !!}
                {!! Form::select('user_id', str_replace('_', ' ', App\Models\User::lists('email', 'id')->all()), null, [ "class" => "form-control users-roles"]) !!}
                @if($errors->has('user_id'))
                    <span class="wow flash error-msg">{{ $errors->first('user_id') }}</span>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('role_id', "You can select more than 1 role:", []) !!}
                {!! Form::select('role_id[]', App\Models\Role::lists('name', 'id')->all(), null, [ "class" => "form-control roles-assignment" , "multiple" => "multiple" ]) !!}
                @if($errors->has('role_id'))
                    <span class="wow flash error-msg">{{ $errors->first('role_id') }}</span>
                @endif
            </div>
            <br/>

            <div class="form-group">
                <a href="#" data-toggle="modal" data-target="#assign">
                    <button class="btn btn-success btn-lg">
                        <span class="glyphicon glyphicon-ok-sign"></span> Assign roles
                    </button>
                </a>
            </div>
        </div>
        <div class="modal fade" id="assign" tabindex="-1" role="dialog" aria-labelledby="assign" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                                    class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title text-center">You are assigning a user this role</h4>
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
