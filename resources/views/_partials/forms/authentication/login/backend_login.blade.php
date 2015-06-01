<div class="col-md-4 col-md-offset-4 login">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $title }} Login</h3>

            @if($displayPasswordHelper == true)
                <div class="password-helper">
                    <a href={{ route('b.password.reset') }}>Forgot password?</a>
                </div>
            @endif
        </div>
        <div class="panel-body">
            <div class="row animated shake">
                @include('_partials.forms.authentication.auth-message', ['ajax_output' => $useAjax])
            </div>
            {!! Form::open(['route' => 'backend.login.post', 'id' => 'loginForm', 'class' => 'form-horizontal', 'role' => 'form', $useAjax ? 'data-remote' : '']) !!}

            <div class="form-group">
                <div class="input-group authentication">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter your email address', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group authentication">
                            <span class="input-group-addon">
                                <i class="fa fa-lock"></i>
                            </span>
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter your password', 'required']) !!}
                </div>
            </div>
            <div class="input-group">
                <div class="checkbox rm">
                    {!! Form::checkbox('remember', 'remember', null, false, []) !!} Remember me
                </div>
            </div>

            <div class="form-group adm-login">
                <div class="col-sm-12 controls">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-sign-in"></i> Log In
                    </button>
                    @if($useAjax)
                        <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                    @endif
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>