@if($useAjax)
    <div class="msgDisplay m-t-10"></div>
@endif
<p>Enter your email address and we'll send you a recovery link, that will allow you to reset your
    password.</p>

<form role="form" method="POST" action="{{ route('reset.postEmail') }}"
      id="forgotPassword" {{ $useAjax ? "data-remote" : "" }}>
    {!! Form::token() !!}

    <div class="form-group">
        <input type="email" name="email" id="email" class="form-control"
               placeholder="Enter your email address" required>
        @if($errors->has('email'))
            <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <button type="submit" class="btn btn-primary" id="sendPassword">
        <i class="fa fa-envelope"></i>&nbsp;Send reset link
    </button>
    @if($useAjax)
        <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
    @endif
</form>