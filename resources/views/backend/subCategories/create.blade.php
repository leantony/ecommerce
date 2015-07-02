@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Create sub-category</title>
@stop

@section('content')
    <div class="row admin-form">
        <div class="col-md-12">
            <h2>Create a product sub-category</h2>
            <h6>Only the name field is required</h6>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::open(['url' => route('backend.subcategories.store'), 'data-remote']) !!}
        <div class="col-md-6 category">

            @include('_partials.forms.categories.categories_form', ['name' => 'Subcategory'])
            <div class="form-group">
                {!! Form::label('category_id', "Pick a category:", []) !!}
                {!! Form::select('category_id', App\Models\Category::lists('name', 'id')->all(), null, [ 'class'=>'form-control']) !!}
                @if($errors->has('category_id'))
                    {{ $errors->first('category_id') }}
                @endif
            </div>
            <hr/>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Create sub-category
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
