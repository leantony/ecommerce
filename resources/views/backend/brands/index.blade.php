@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Product brands</title>
@stop

@section('content')

    <h3>Product Brands</h3>
    <p>Brands allow the user to identify a product to a specific manufacturer. All brands present are listed
        below</p>
    <p>Each brand has a logo, for easy identification</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.brands.create') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-plus"></i>&nbsp;Add product Brand
                    </button>
                </a>
            </div>
        </div>

        <div class="col-md-12 m-t-20">
            <table id="brands-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Product count</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@stop