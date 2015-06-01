@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Admin - Help articles</title>
@stop

@section('content')
    @if($articles->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p class="text-center">There are no articles to display. Please <a
                                href="{{ route('backend.articles.create') }}"> add some</a></p>
                </div>
            </div>
            <br/>
        </div>
    @else
        <h3>All help articles</h3>
        <hr/>
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <div class="pull-right">
                    <a href="{{ route('backend.articles.create') }}">
                        <button class="btn btn-success">
                            <i class="fa fa-plus"></i>&nbsp;Create article
                        </button>
                    </a>
                </div>
            </div>
            <hr/>
            <div class="col-md-12 m-t-20">
                <div class="table-responsive">
                    <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"
                           data-sort-name="article_id"
                           data-sort-order="asc" data-search="true"
                           data-show-toggle="true"
                           data-show-columns="true">
                        <thead>
                        <tr>
                            <th data-field="article_id" data-sortable="true">Article ID</th>
                            <th data-field="article_topic" data-sortable="true">Topic</th>
                            <th data-field="article_created" data-sortable="true">Date created</th>
                            <th data-field="article_edited" data-sortable="true">Date Modified</th>
                            <th data-field="edit">Edit</th>
                            <th data-field="delete">Remove</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($articles as $article)
                            <tr>
                                <td>{{ $article->id }}</td>
                                <td>

                                    {{ $article->topic }}

                                </td>
                                <td>{{ $article->created_at }}</td>
                                <td>{{ $article->updated_at }}</td>
                                <td>
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href="{{ route('backend.articles.edit', ['article' => $article->id]) }}">
                                            <button class="btn btn-primary btn-xs">
                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit
                                            </button>
                                        </a>

                                    </p>
                                </td>
                                <td>
                                    <p data-placement="top">
                                        <a href="#" data-toggle="modal"
                                           data-target="#deleteArticle{{ $article->id }}">
                                            <button class="btn btn-warning btn-xs">
                                                <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                                            </button>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                            @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteArticle'.$article->id, 'route' => route('backend.articles.destroy', ['id' => $article->id])])
                        @endforeach
                        </tbody>

                    </table>
                    {!! $articles->render() !!}
                </div>
            </div>
            @endif
        </div>

@stop