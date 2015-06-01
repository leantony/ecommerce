@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>View help - {{ beautify($article->topic) }}</title>
@stop

@section('slider')

@stop
@section('content')

    <div class="container m-b-40 m-t-20">
        <div class="row">
            @include('_partials.forms.help.article-content', ['displayTitle' => true])
        </div>
    </div>

@stop

@section('brands')

@stop

@section('footer')
    @include('layouts.frontend.sections.footer.footer-basic')
@stop