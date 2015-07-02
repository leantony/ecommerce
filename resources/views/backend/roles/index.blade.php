@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - System Roles</title>
@stop

@section('content')
    @if($roles->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p class="text-center">You currently have not configured any roles. Please <a
                                href="{{ route('backend.security.roles.create') }}"> create some</a></p>
                </div>
            </div>
        </div>
    @else
        <h3>Current System Roles</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="find a system role..">
              <span class="input-group-btn">
              <button class="btn btn-primary" type="button">
                  <span class="glyphicon glyphicon-search"></span>
              </button>
             </span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="pull-right">
                    <a href="{{ route('backend.security.roles.create') }}">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i>&nbsp;Add user Role
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive">
                    <table id="userData" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Date created</th>
                            <th>Date Modified</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>
                                    <a href="{{ route('backend.security.roles.show', ['id' => $role->id]) }}">
                                        {{ beautify($role->name) }}
                                    </a>

                                </td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>{{ $role->updated_at }}</td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href="{{ route('backend.security.roles.update', ['id' => $role->id]) }}">
                                            <button class="btn btn-primary btn-xs">
                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                            </button>
                                        </a>

                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $roles->render() }}
                </div>
            </div>
            @endif
        </div>

@stop