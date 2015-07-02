@extends('layouts.backend.master')

@section('header')
    @parent
    <title>System permissions</title>
@stop

@section('content')
    @if($permissions->isEmpty())
        <div class="alert alert-danger">
            <p class="text-center">You currently have not configured any permissions. Please <a
                        href="{{ route('backend.security.permissions.create') }}"> create some</a></p>
        </div>
    @endif
    <h2>Permissions</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" placeholder="find a permission..">
              <span class="input-group-btn">
              <button class="btn btn-primary" type="button">
                  <span class="glyphicon glyphicon-search"></span>
              </button>
             </span>
            </div>
        </div>

        <div class="col-md-8">
            <div class="pull-right">
                <a href="{{ route('backend.security.permissions.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-plus"></i>&nbsp;Create permission
                    </button>
                </a>
            </div>
        </div>

        <div class="col-md-12 table-responsive m-t-10">
            <table id="userData" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Permission Name</th>
                    <th>Display name</th>
                    <th>Description</th>
                    <th>Role(s) Assigned</th>
                    <th>Date created</th>
                    <th>Date Modified</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->display_name }}</td>
                        <td>{{ $permission->description }}</td>
                        <td>
                            @if($permission->roles->count() == 0)
                                None
                            @else
                                @foreach($permission->roles as $role)
                                    {{ $role->name . ', ' }}
                                @endforeach
                                <br/>
                            @endif
                        </td>
                        <td>{{ $permission->created_at }}</td>
                        <td>{{ $permission->updated_at }}</td>
                        <td>
                            <p data-placement="top" data-toggle="tooltip" title="Edit">
                                <a href="{{ route('backend.security.permissions.edit', ['id' => $permission->id]) }}">
                                    <button class="btn btn-info btn-xs">
                                        <span class="fa fa-edit"></span>&nbsp;Edit
                                    </button>
                                </a>

                            </p>
                        </td>
                        <td>
                            <p data-placement="top">
                                <a href="#" data-toggle="modal"
                                   data-target="#deletePermission{{ $permission->id }}">
                                    <button class="btn btn-warning btn-xs">
                                        <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                                    </button>
                                </a>
                            </p>
                        </td>
                    </tr>
                    @include('_partials.modals.actionModals.delete', ['elementID' => 'deletePermission'.$permission->id, 'route' => route('backend.security.permissions.destroy', ['id' => $permission->id])])
                @endforeach
                </tbody>
            </table>
            {{ $permissions->render() }}
        </div>
    </div>
@stop