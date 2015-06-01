@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Modify Users</title>
@stop

@section('content')
    @if($users->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p class="text-center">There are no users registered on the site. Please
                        <a href="{{ action('Backend\UsersController@create') }}"> add some</a></p>
                </div>
                <hr/>
                <p>This is not good</p>
            </div>
        </div>

    @endif
    <h3>System users</h3>
    <p>This are all users registered on the site</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#addUser">
                    <button class="btn btn-success">
                        <i class="fa fa-user-plus"></i>&nbsp;Add User
                    </button>
                </a>
            </div>
        </div>
        <hr/>
        <div class="col-md-12" style="margin-top: 20px">
            <div class="table-responsive">
                <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"
                       data-sort-name="user_name"
                       data-sort-order="asc" data-search="true"
                       data-show-toggle="true"
                       data-show-columns="true">
                    <thead>
                    <tr>
                        <th data-field="user_name" data-sortable="true">Name</th>
                        <th data-field="user_phone" data-sortable="true">Phone</th>
                        <th data-field="user_email" data-sortable="true">Email</th>
                        <th data-field="user_county" data-sortable="true">County</th>
                        <th data-field="user_town" data-sortable="true">Town</th>
                        <th data-field="user_address" data-sortable="true">Home Address</th>
                        <th data-field="edit">Edit</th>
                        <th data-field="delete">Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="{{ eq($user->id, $auth_user->getAuthIdentifier()) ? 'info' : '' }}">
                            <td>
                                <a href="#" data-toggle="modal" data-target="#editUser{{ $user->id }}">
                                    {{ $user->getUserName() }}
                                </a>
                            </td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ empty($user->county) ? str_replace("'", '', 'None') : $user->county->name }}</td>
                            <td>{{ $user->town }}</td>
                            <td>{{ $user->home_address }}</td>
                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Edit">
                                    <a href="{{ route('backend.users.edit', ['id' => $user->id]) }}">
                                        <button class="btn btn-primary btn-xs">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                        </button>
                                    </a>

                                </p>
                            </td>
                            <td>
                                <p data-placement="top">
                                    <a href="#" data-toggle="modal" data-target="#deleteUser{{ $user->id }}">
                                        <button class="btn btn-warning btn-xs">
                                            <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                                        </button>
                                    </a>
                                </p>
                            </td>
                        </tr>
                        @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteUser'.$user->id, 'route' => route('backend.users.destroy', ['id' => $user->id])])
                    @endforeach
                    </tbody>
                </table>
                {!! $users->render() !!}
            </div>
        </div>

    </div>
    @include('_partials.modals.users.addUser', ['elementID' => 'addUser', 'passwords' => true])
@stop