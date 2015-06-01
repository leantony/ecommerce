<div class="form-group m-t-10 m-b-10">
    {!! Form::label('recaptcha', 'Solve the recaptcha below *') !!}
    &nbsp;<span>{!! link_to('https://www.google.com/recaptcha/intro/index.html', 'what is this?', ['target' => '_blank']) !!}</span>
    {!! Recaptcha::render() !!}

    @if($errors->has('g-recaptcha-response'))
        <span class="wow flash error-msg">{!! $errors->first('g-recaptcha-response') !!}</span>
    @endif
</div>