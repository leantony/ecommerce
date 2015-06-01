@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Help page</title>
@stop

@section('slider')

@stop
@section('content')

    <div class="container m-b-40 m-t-20">
        <div class="row">
            <div class="col-md-12 m-b-20">
                <h2>Help page</h2>
                <hr/>
                <p>We have {{ $articles->count() }} articles ready for you. Browse an article to get started</p>
                <br/>

                <div class="col-md-6 m-t-40">
                    {!! $articles->render() !!}
                    @foreach($articles as $article)

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    {{ $article->id }}:
                                    <a href="{{ route('help.article.view', ['article' => $article->id]) }}">
                                        {{ $article->topic }}
                                    </a>
                                </h3>
                            </div>
                            <div class="panel-body">
                                {!! $article->content !!}
                            </div>
                        </div>
                        <hr/>
                    @endforeach
                    {!! $articles->render() !!}
                </div>

            </div>
        </div>
    </div>


@stop

@section('brands')

@stop