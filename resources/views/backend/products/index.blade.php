@extends('layouts.backend.master')

@section('header')
    @parent
    <title>All Products</title>
@stop

@section('content')

    <h3>All products (Inventory)</h3>
    <p>Here is the full product catalogue</p>
    <p>Total inventory count (sum of all product quantities): <b>{{ $inventoryCount }}</b></p>
    <p>Products in inventory (sum of all individual products): <b>{{ $productsCount }}</b></p>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right" style="right: 10px">
                <a href="{{ route('backend.products.create') }}">
                    <button class="btn btn-success" data-title="Create" data-toggle="modal"
                            data-target="#create">
                        <i class="fa fa-plus"></i>&nbsp;Add product
                    </button>
                </a>

            </div>
        </div>
        <!-- /input-group -->
        <br/>

        <div class="col-md-12 m-t-20">
            <!-- /input-group -->
            <table id="products-table" class="table table-bordered" data-table-enable-utilities='1'>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@stop