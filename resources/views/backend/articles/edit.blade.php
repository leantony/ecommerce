@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Update article</title>
@stop

@section('content')
    <div class="row admin-form">
        <div class="col-md-12">
            <h2>Edit Article</h2>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::model($article, ['url' => route('backend.articles.update', ['article' => $article->id]), 'method' => 'PATCH']) !!}
        <div class="col-md-10">

            @include('_partials.forms.Articles.help.form')
            <hr/>
            <div class="pull-right">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> update article
                </button>
            </div>
            <div class="pull-left">
                <a href="#" data-toggle="modal" data-target="#deleteArticle{{ $article->id }}">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteArticle'.$article->id, 'route' => route('backend.articles.destroy', ['article' => $article->id])])
@stop