<div class="col-md-4 col-md-offset-2">
    <h3>Reset your password here: </h3>

    <p>You will be automatically signed in, once you finish</p>
    <hr/>
    <form role="form" method="POST" action="{{ route('reset.finish') }}" id="resetPasswordForm">
        {!! Form::token() !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" class="form-control"
                   placeholder="Enter your email address" value="{{ old('email') }}" required>
            @if($errors->has('email'))
                <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="password">New password:</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Enter your new password" required>
            @if($errors->has('password'))
                <span class="wow flash error-msg">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="password_confirmation">Repeat new password:</label>
            <input type="password" class="form-control" id="password_confirmation"
                   name="password_confirmation" placeholder="Repeat your new password" required>
            @if($errors->has('password_confirmation'))
                <span class="wow flash error-msg">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
        <br/>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Save new password</button>
    </form>
</div>