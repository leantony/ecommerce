@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Edit product brand</title>
@stop

@section('content')
    <div class="row admin-form">
        <h2>Modify a product brand / manufacturer</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a href="{{ url(URL::previous()) }}">
                        <button class="btn btn-primary"><i class="fa fa-arrow-left"></i>&nbsp;Back</button>
                    </a>
                </div>

            </div>
        </div>

        <hr/>
        <div class="msgDisplay m-t-10"></div>
        {!! Form::model($brand,['url' => action('Backend\BrandsController@update', ['id' => $brand->id]), 'method' => 'PATCH', 'files' => true ]) !!}
        <div class="col-md-6">

            @include('_partials.forms.brands.brands_form')

            <hr/>
            <div class="pull-left">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Finish edit
                </button>
            </div>
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#deleteBrand">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>


        </div>

        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteBrand', 'route' => route('backend.brands.destroy', ['id' => $brand->id])])
@stop