<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<!-- stylesheets -->
{!! HTML::style('css/frontend/libs.css') !!}
{!! HTML::style('css/frontend/main.css') !!}
<!-- main font -->
<link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
{!! HTML::script('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') !!}
{!! HTML::script('//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') !!}
<![endif]-->
<!-- site Icon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">