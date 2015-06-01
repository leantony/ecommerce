@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>User Registration</title>
@stop

@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true, 'altText' => 'Authentication'])
@stop

@section('slider')

@stop

@section('content')

    <div class="container">
        <div class="row m-t-40 m-b-40">
            <div class="col-md-5">
                <p>Hey {{ $user->getName() }}. Please fill in this form to complete your registration</p>

                <p>You will be able to customize your account later</p>
                <hr/>
                {!! Form::open(['url' => route('auth.fill.post')]) !!}
                <div class="msgDisplay m-t-10"></div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="Enter email address" value="{{ $user->email }}" disabled>
                    @if($errors->has('email'))
                        <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" maxlength="100" required
                           placeholder="Enter your password">
                    @if($errors->has('password'))
                        <span class="wow flash error-msg">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Repeat your password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control" maxlength="100" placeholder="Repeat your password" required>
                    @if($errors->has('password_confirmation'))
                        <span class="wow flash error-msg">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <div class="field-row form-group">
                    <input type="checkbox" name="accept">

                    <span>I agree to the <a href="{{ route('terms') }}" target="_blank">Terms and conditions</a> </span>
                    <br/>
                    @if($errors->has('accept'))
                        <span class="wow flash error-msg">{{ $errors->first('accept') }}</span>
                    @endif
                </div>
                <hr/>
                <button class="btn btn-primary btn-lg" type="submit">
                    <i class="fa fa-plus"></i>&nbsp; Create My Account
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('brands')

@stop