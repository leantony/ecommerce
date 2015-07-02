@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Create a new product Manufacturer/brand</title>
@stop

@section('content')
    <div class="row admin-form">
        <div class="col-md-12">
            <h2>Add a new product brand</h2>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::open(['url' => route('backend.brands.store'), 'files' => true]) !!}
        <div class="col-md-6 category">

            @include('_partials.forms.brands.brands_form')
            <hr/>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Add the brand
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop