@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Modify Users</title>
@stop

@section('content')
    <h3>System users</h3>
    <p>This are all users registered on the site</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.users.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-user-plus"></i>&nbsp;Add User
                    </button>
                </a>
            </div>
        </div>
        <hr/>
        <div class="col-md-12 m-t-20">
            <!-- /input-group -->
            <table id="users-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>County</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
@stop