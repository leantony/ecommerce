{!! isset($heading) ? "<h3>Sign In to your account</h3><hr/>" : "" !!}
@if(api_login_enabled())

    @include('_partials.forms.authentication.oauth', ['action' => 'Sign in'])

@endif
<div class="row animated shake">
    @include('_partials.forms.authentication.auth-message', ['ajax_output' => $useAjax])
</div>
<form role="form" method="POST" action="{{ route('login.verify') }}" id="loginForm" {{ $useAjax ? "data-remote" : "" }}>
    {!! Form::token() !!}
    <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" class="form-control"
               placeholder="Enter your email address" required value="{{ old('email') }}">
        @if($errors->has('email'))
            <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password"
               placeholder="Enter your password" required>
        @if($errors->has('password'))
            <span class="wow flash error-msg">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember Me&nbsp;
                <a href="{{ route('help.article.view', ['article' => 4, 'popup' => true]) }}" data-help target="_blank">
                    <i class="fa fa-question-circle"></i>
                </a>
            </label>
            <label class="pull-right">
                <a href="{{ route('password.reset') }}">I forgot my password
                </a>
            </label>
        </div>

    </div>
    @if(isset($recaptcha))
        <p class="text text-danger">We've detected unusual request activity from your IP address
            of {{ Request::getClientIp() }}. You'll need to prove that you're not a robot</p>
        @include('_partials.forms.authentication.recaptcha')
    @endif
    <br/>
    <button type="submit" class="btn btn-primary {{ $extra_class }}"><i class="fa fa-sign-in"></i>&nbsp;Sign
        in
    </button>
    <hr/>
    <a href="{{ route('help.article.view', ['article' => 1, 'popup' => true]) }}" data-help>
        I don't know how to log in
    </a>
    <hr/>
    @if(Request::isSecure() & !isset($display_security_assurance))
        <a href="{{ route('help.article.view', ['article' => 5, 'popup' => true]) }}" data-help data-height="570"
           data-width="580">
            {{ "Is my data transmitted securely?" }}
        </a>
    @endif
</form>
{{--@include('_partials.modals.account.forgotPassword', ['elementID' => 'forgotPasswordModal'])--}}