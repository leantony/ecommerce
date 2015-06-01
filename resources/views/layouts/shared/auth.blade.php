<!DOCTYPE html>
<html>
@section('head')
    <head lang="en">
        <meta charset="UTF-8">
        <title>Authentication</title>
        {!! HTML::style('css/frontend/libs.css')!!}
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        {!! HTML::script('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') !!}
        {!! HTML::script('//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') !!}
        <![endif]-->
        <link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        {!! HTML::style('css/backend/backend.css')!!}
        {!! HTML::style('css/backend/general.css')!!}
        <!-- site Icon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    </head>

@show
<body id="authentication">
<div class="container-fluid ">
    <div id="ajax-image"></div>
    @section('content')

    @show
</div>
</body>
@section('scripts')
    {!! HTML::script('js/frontend/libs.js') !!}
    {!! HTML::script('js/frontend/main.js') !!}
@show
</html>