@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Users and their roles</title>
@stop

@section('content')
    @if($users->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p class="text-center">No roles have been assigned to any user. To get
                        started, {!! link_to_route('backend.security.access-control.roles.create', 'assign roles to users') !!} </p>
                </div>
            </div>
            <br/>
        </div>
    @else
        <h3>Users & Roles</h3>
        <p>Users who have been assigned roles have been listed below</p>
        <hr/>
        <div class="row">
            <div class="col-md-4">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="find a user">
              <span class="input-group-btn">
              <button class="btn btn-primary" type="button">
                  <span class="glyphicon glyphicon-search"></span>
              </button>
             </span>
                </div>
            </div>
            <!-- /input-group -->

            <div class="pull-right">
                <a href="{{ route('backend.security.access-control.roles.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-plus"></i>&nbsp;Assign role to user
                    </button>
                </a>
            </div>

            <div class="col-md-12 m-t-20">
                <div class="table-responsive">
                    <table id="userData" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Roles</th>
                        </tr>
                        </thead>
                        @foreach($users as $user)
                            <tbody>
                            <tr>
                                <td>
                                    <a href="{{ route('backend.users.show', ['id' => $user->id]) }}">
                                        {{ $user->present()->fullName }}
                                    </a>
                                </td>
                                <td>

                                    @foreach($user->roles as $role)
                                        {{ $role->name . ', ' }}
                                    @endforeach
                                    <br/>

                                </td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href="{{ route('backend.security.access-control.roles.edit', ['id' => $user->id]) }}">
                                            <button class="btn btn-primary btn-xs"><span
                                                        class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                            </button>
                                        </a>

                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            @endif
        </div>
@stop