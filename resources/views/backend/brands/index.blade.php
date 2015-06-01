@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Product brands</title>
@stop

@section('content')
    @if($brands->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p class="text-center">There are no product brands to display. Please <a
                                href="{{ action('Backend\BrandsController@create') }}"> add some</a></p>
                </div>
            </div>
            <br/>

            <p>Brands allow the user to identify a product to a specific manufacturer. An example of a brand is Nokia,
                Samsung, etc</p>
        </div>
    @else
        <h3>Product Brands</h3>
        <p>Brands allow the user to identify a product to a specific manufacturer. All brands present are listed
            below</p>
        <p>Each brand has a logo, for easy identification</p>
        <hr/>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <div class="pull-right">
                    <a href="#" data-toggle="modal" data-target="#createBrand">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i>&nbsp;Add product Brand
                        </button>
                    </a>
                </div>
            </div>

            <div class="col-md-12 m-t-20">
                <div class="table-responsive">
                    <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"
                           data-sort-name="brand_id"
                           data-sort-order="asc" data-search="true"
                           data-show-toggle="true"
                           data-show-columns="true">
                        <thead>
                        <tr>
                            <th data-field="brand_id" data-sortable="true">Brand ID</th>
                            <th data-field="brand_name" data-sortable="true">Name</th>
                            <th>Logo</th>
                            <th data-field="brand_product_count" data-sortable="true">Product count</th>
                            <th data-field="brand_created" data-sortable="true">Date created</th>
                            <th data-field="brand_modified" data-sortable="true">Date Modified</th>
                            <th data-field="edit">Edit</th>
                            <th data-field="delete">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>
                                    <a href="{{ route('backend.brands.show', ['id' => $brand->id]) }}">
                                        {{ beautify($brand->name) }}
                                    </a>
                                </td>
                                <td>
                                    <a data-lightbox="image-1" data-title="{{ $brand->name }}"
                                       href="{{ display_img($brand, false, 'logo')  }}">
                                        <button class="btn btn-success btn-xs">
                                            <span class="fa fa-eye"></span>&nbsp;View logo
                                        </button>
                                    </a>
                                </td>
                                @if(is_null($brand->products->count()))
                                    <td>None</td>
                                @else
                                    <td>{{ $brand->products->count() }}</td>
                                @endif
                                @if(is_null(date($brand->created_at)))
                                    <td>N/A</td>
                                @else
                                    <td>{{ $brand->created_at }}</td>
                                @endif
                                <td>{{ $brand->updated_at }}</td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href="#" data-toggle="modal" data-target="#editBrand{{ $brand->id }}">
                                            <button class="btn btn-primary btn-xs"><span
                                                        class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                            </button>
                                        </a>

                                    </p>
                                </td>
                                <td>
                                    <p data-placement="top">
                                        <a href="#" data-toggle="modal" data-target="#deleteBrand{{ $brand->id }}">
                                            <button class="btn btn-warning btn-xs">
                                                <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                                            </button>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                            @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteBrand'.$brand->id, 'route' => route('backend.brands.destroy', ['id' => $brand->id])])
                            @include('_partials.modals.brands.editBrand', ['elementID' => 'editBrand'.$brand->id])
                        @endforeach
                        </tbody>

                    </table>
                    {!! $brands->render() !!}
                </div>
            </div>

            @endif
            @include('_partials.modals.brands.addBrand', ['elementID' => 'createBrand'])
        </div>
@stop