@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Help articles</title>
@stop

@section('content')

    <h3>All help articles</h3>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.articles.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-plus"></i>&nbsp;Create article
                    </button>
                </a>
            </div>
        </div>
        <hr/>
        <div class="col-md-12 m-t-20">
            <!-- /input-group -->
            <table id="articles-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Topic</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@stop