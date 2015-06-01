@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>PC World Help - {{ $article->topic }}</title>
@stop
@section('main-nav')

@stop
@section('breadcrumbs')

@stop
@section('slider')

@stop

@section('content')
    <div class="container m-b-40 m-t-20">
        <div class="row">

            @include('_partials.forms.help.article-content', ['displayTitle' => false, 'size' => 12])

            <div class="col-md-4">
                <a href="javascript:" data-close-popup>
                    <button class="btn btn-info">
                        <i class="fa fa-times"></i>&nbsp;close this window
                    </button>
                </a>
            </div>

        </div>
    </div>
@stop

@section('brands')

@stop
@section('footer')

@stop