@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - sub-categories</title>
@stop

@section('content')

    <h3>Product sub-categories</h3>
    <p>Subcategories help group products in a specific category together. This will also be displayed in the site's
        navigation bar, under their related category</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.subcategories.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-plus"></i>&nbsp;Create new Subcategory
                    </button>

                </a>
            </div>
        </div>

        <div class="col-md-12 m-t-20">
            <!-- /input-group -->
            <table id="subcategories-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@stop