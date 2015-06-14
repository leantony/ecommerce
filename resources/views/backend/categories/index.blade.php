@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Categories</title>
@stop

@section('content')
    <h3>Product Categories</h3>
    <p>Categories help to group similar products. This categories listed below will be displayed on the site's
        navigation bar</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.categories.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-plus"></i>&nbsp;Create Category
                    </button>
                </a>
            </div>
        </div>
        <hr/>
        <div class="col-md-12 m-t-20">
            <table id="categories-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@stop