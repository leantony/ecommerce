<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<meta charset="UTF-8">
{!! HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css') !!}
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
{!! HTML::script('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') !!}
{!! HTML::script('//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') !!}
<![endif]-->
<link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
{!! HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') !!}
{!! HTML::style('/css/mail/mail.css', [], true) !!}

<div class="container-fluid mail-container">
    <div class="row">
        <div class="col-md-4">
            <h2>Hello, {{ ucfirst(array_get($data, 'user')) }}</h2>

            <p>
                Thank you for creating an account at PC-World. We are pleased to have you on board. Please click the
                button below to complete the registration process.
            </p>
            <br/>
            <a href="{{ secure_url(array_get($data, 'link_')) }}">
                <button class="btn btn-success btn-lg center-block" type="submit">
                    <i class="fa fa-user"></i>&nbsp;<b>Activate my Account</b>
                </button>
            </a>

            <br/>
        </div>

    </div>

</div>
