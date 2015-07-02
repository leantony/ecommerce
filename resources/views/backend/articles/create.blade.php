@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Create a new article</title>
@stop

@section('content')
    <div class="row admin-form">
        <div class="col-md-12">
            <h2>Add a new article</h2>

            <p>For now, you can only create help articles</p>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::open(['url' => route('backend.articles.store')]) !!}
        <div class="col-md-6">

            @include('_partials.forms.Articles.help.form')
            <hr/>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> create article
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop