@extends('layouts.backend.master')

@section('header')
    @parent
    <title>All Products</title>
@stop

@section('content')

    @if($products->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <p class="text-center">The entire product catalog is empty. Please <a
                                href="{{ action('Backend\ProductsController@create') }}"> add some products</a></p>
                </div>
                <br/>

                <p>This defines what you sell to the user. You just cant have an empty product catalogue.</p>
            </div>
        </div>

    @else
        <h3>All products (Inventory)</h3>
        <p>Here is the full product catalogue</p>
        <p>Total inventory count (sum of all product quantities): <b>{{ $inventoryCount }}</b></p>
        <p>Products in inventory (sum of all individual products): <b>{{ $productsCount }}</b></p>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <div class="pull-right" style="right: 10px">
                    <a href="{{ action('Backend\ProductsController@create') }}">
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
                <div class="table-responsive">
                    <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"
                           data-sort-name="product_id"
                           data-sort-order="asc" data-search="true"
                           data-show-toggle="true"
                           data-show-columns="true">
                        <thead>
                        <tr>
                            <th data-field="product_id" data-sortable="true">ID</th>
                            <th data-field="product_name" data-sortable="true">Name</th>
                            <th data-field="product_category" data-sortable="true">Category</th>
                            <th data-field="product_sub_category" data-sortable="true">Sub-category</th>
                            <th data-field="product_brand" data-sortable="true">Manufacturer</th>
                            <th data-field="product_quantity" data-sortable="true">Qt</th>
                            <th data-field="product_price" data-sortable="true">Price</th>
                            <th data-field="product_tax_status" data-sortable="true">Tax status</th>
                            <th data-field="product_discount" data-sortable="true">Discount (%)</th>
                            <th data-field="product_final_price" data-sortable="true">Final price</th>
                            <th data-field="edit">Edit</th>
                            <th data-field="delete">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>

                                <td>
                                    <a href="{{ route('backend.categories.show', ['id' => $product->category->id]) }}">
                                        {{ !is_null($product->category->name) ? $product->category->name : "None" }}
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ route('backend.subcategories.show', ['id' => $product->subcategory->id]) }}">
                                        {{ !is_null($product->subcategory->name) ? $product->subcategory->name : "None" }}
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ route('backend.brands.show', ['id' => $product->brand->id]) }}">
                                        {{ !is_null($product->brand->name) ? $product->brand->name : "None" }}
                                    </a>
                                </td>
                                <td>
                                    {{ $product->quantity }}
                                </td>
                                <td>{{ format_money($product->value()) }}</td>
                                @if($product->taxable)
                                    <td>TAXABLE</td>
                                @else
                                    <td>EXEMPTED</td>
                                @endif
                                @if($product->hasDiscount())
                                    <td>{{ $product->getDiscountRate() }}</td>
                                @else
                                    <td>None</td>
                                @endif
                                @if(!$product->hasDiscount())
                                    <td>{{ format_money($product->value()) }}</td>
                                @else
                                    <td>{{ format_money($product->valuePlusTax()) }}</td>
                                @endif
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href="{{ action('Backend\ProductsController@edit', ['id' => $product->id]) }}">
                                            <button class="btn btn-primary btn-xs"><span
                                                        class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                            </button>
                                        </a>
                                    </p>
                                <td>
                                    <p data-placement="top">
                                        <a href="#" data-toggle="modal" data-target="#deleteProduct{{ $product->id }}">
                                            <button class="btn btn-warning btn-xs">
                                                <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                                            </button>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                            @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteProduct'.$product->id, 'route' => route('backend.products.destroy', ['id' => $product->id])])
                        @endforeach
                        </tbody>
                    </table>
                    {!! $products->render() !!}
                </div>
            </div>
            @endif
        </div>
@stop