@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Create category</title>
@stop

@section('content')

    <div class="row admin-form">
        <div class="col-md-12">
            <h2>Create a product Category</h2>
            <h6>You are free to fill in all fields, but only the name field is required</h6>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::open(['url' => route('backend.categories.store'), 'files' => true, 'data-remote']) !!}
        <div class="col-md-6 category">

            @include('_partials.forms.categories.categories_form', ['name' => 'Category'])
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg">
                    <span class="glyphicon glyphicon-ok-sign"></span> Create Category
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop