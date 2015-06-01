@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Edit sub-category</title>
@stop

@section('content')
    <div class="row admin-form">
        <h2>Modify a product sub-category</h2>

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
        {!! Form::model($subcategory,['url' => action('Backend\SubCategoriesController@update', ['id' => $subcategory->id]), 'method' => 'PATCH', 'files' => true, 'data-remote']) !!}
        <div class="col-md-6">

            @include('_partials.forms.categories.categories_form', ['name' => 'Subcategory'])
            <div class="form-group">
                {!! Form::label('category_id', "Pick a category:", []) !!}
                {!! Form::select('category_id', App\Models\Category::lists('name', 'id'), null, [ 'class'=>'form-control']) !!}
                @if($errors->has('category_id'))
                    {{ $errors->first('category_id') }}
                @endif
            </div>
            <hr/>
            <div class="pull-left">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Finish edit
                </button>
            </div>
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#deleteSubCategory">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteSubCategory', 'route' => route('backend.subcategories.destroy', ['id' => $subcategory->id])])
@stop