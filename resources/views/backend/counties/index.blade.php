@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Counties</title>
@stop

@section('content')

    <h3>All counties</h3>
    <p>Counties will serve as a guide to the user, about which locations the products they buy will be shipped to</p>
    <p>Once you add a county to this list, the user may use it as a shipping destination</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.counties.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-plus"></i>&nbsp;Add county
                    </button>
                </a>
            </div>
        </div>

        <div class="col-md-12 m-t-20">
            <!-- /input-group -->
            <table id="counties-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Alias</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
@stop