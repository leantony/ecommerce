@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Add Product</title>
@stop

@section('content')
    <h2>New product</h2>
    <hr/>
    <div class="row">
        <div class="msgDisplay m-t-10"></div>
        {!! Form::open(['url' => route('backend.products.store'), 'files' => true]) !!}
        @include('_partials.forms.products.products_form')
        <br/>

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <button type="submit" class="btn btn-success">
                        <span class="glyphicon glyphicon-ok-sign"></span> Add this product
                    </button>
                </div>
            </div>
        </div>

        {!! Form::close() !!}

    </div>
@stop
