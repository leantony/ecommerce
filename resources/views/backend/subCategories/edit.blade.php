@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Edit sub-category</title>
@stop

@section('content')
    <div class="row admin-form">
        <div class="col-md-12">
            <h2>Modify a product sub-category</h2>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::model($subcategory,['url' => route('backend.subcategories.update', ['subcategory' => $subcategory->id]), 'method' => 'PATCH', 'files' => true]) !!}
        <div class="col-md-6">

            @include('_partials.forms.categories.categories_form', ['name' => 'Subcategory'])
            <div class="form-group">
                {!! Form::label('category_id', "Pick a category:", []) !!}
                {!! Form::select('category_id', App\Models\Category::lists('name', 'id')->all(), null, [ 'class'=>'form-control']) !!}
                @if($errors->has('category_id'))
                    {{ $errors->first('category_id') }}
                @endif
            </div>
            <hr/>
            <div class="pull-right">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Finish edit
                </button>
            </div>
            <div class="pull-left">
                <a href="#" data-toggle="modal" data-target="#deleteSubCategory">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteSubCategory', 'route' => route('backend.subcategories.destroy', ['subcategory' => $subcategory->id])])
@stop
