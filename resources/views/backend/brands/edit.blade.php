@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Edit product brand</title>
@stop

@section('content')
    <div class="row admin-form">
        <div class="col-md-12">
            <h2>Modify a product brand / manufacturer</h2>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::model($brand, ['url' => route('backend.brands.update', ['brand' => $brand->id]), 'method' => 'PATCH', 'files' => true ]) !!}
        <div class="col-md-6">

            @include('_partials.forms.brands.brands_form')

            <hr/>
            <div class="pull-right">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Finish edit
                </button>
            </div>
            <div class="pull-left">
                <a href="#" data-toggle="modal" data-target="#deleteBrand">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>


        </div>

        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteBrand', 'route' => route('backend.brands.destroy', ['brand' => $brand->id])])
@stop