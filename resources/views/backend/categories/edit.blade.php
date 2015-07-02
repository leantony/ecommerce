@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Modify category</title>
@stop

@section('content')
    <div class="row admin-form">

        <div class="col-md-12">
            <h2>Editing category [ <b>{{ $category->name }}</b> ]</h2>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::model($category, ['url' => route('backend.categories.update', ['category' => $category->id]) , 'method' => 'PATCH']) !!}
        <div class="col-md-6 category">

            @include('_partials.forms.categories.categories_form', ['name' => 'Category'])

            <hr/>
            <div class="pull-right">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Finish Edit
                </button>
            </div>
            <div class="pull-left">
                <a href="#" data-toggle="modal" data-target="#deleteCategory">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>
        </div>
        {!! Form::close() !!}

        @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteCategory', 'route' => route('backend.categories.destroy', ['category' => $category->id])])
    </div>
@stop