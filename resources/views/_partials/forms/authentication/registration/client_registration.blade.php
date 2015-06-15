@if(api_registration_enabled())

    @include('_partials.forms.authentication.oauth', ['action' => 'Sign up'])

@endif
<br/>
<p class="text-info">*All fields are required</p>
<form action="{{ route('registration.store') }}" method="POST"
      id="registrationForm" {{ $useAjax ? "data-remote" : "" }}>
    {!! Form::token() !!}
    @if($useAjax)
        <div class="msgDisplay m-t-10"></div>
    @endif
    <div class="form-group m-t-20">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" class="form-control" maxlength="20"
               placeholder="Enter your first name" value="{{ old('first_name') }}" required>
        @if($errors->has('first_name'))
            <span class="wow flash error-msg">{{ $errors->first('first_name') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="last_name">Second Name:</label>
        <input type="text" id="last_name" name="last_name" class="form-control" maxlength="20"
               placeholder="Enter your second name" value="{{ old('last_name') }}" required>
        @if($errors->has('last_name'))
            <span class="wow flash error-msg">{{ $errors->first('last_name') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="county_id">Select your county:</label>
        {!! Form::select('county_id', str_replace('_', ' ', App\Models\County::lists('name', 'id')->all()), null,  [ 'class'=>'form-control', 'id' => 'county-input']) !!}
    </div>
    <div class="form-group">
        <label for="town">Hometown: </label>
        <input type="text" id="town" name="town" class="form-control" maxlength="20"
               placeholder="It should exist within your selected county" required>
        @if($errors->has('town'))
            <span class="wow flash error-msg">{{ $errors->first('town') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="home_address">Home Address (where you live):</label>
                            <textarea id="home_address" name="home_address" rows="4"
                                      placeholder="Enter your home address" maxlength="100" required
                                      class="form-control">{{ old('home_address') }}</textarea>
        @if($errors->has('home_address'))
            <span class="wow flash error-msg">{{ $errors->first('home_address') }}</span>
        @endif
    </div>

    <div class="form-group">
        <label for="phone">Phone number:</label>

        <div class="input-group">
            <span class="input-group-addon">+254</span>
            <input type="text" id="phone" name="phone" placeholder="712345678" maxlength="9" required
                   value="{{ old('phone') }}" class="form-control">
        </div>
        @if($errors->has('phone'))
            <span class="wow flash error-msg">{{ $errors->first('phone') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" class="form-control"
               placeholder="Enter email address" value="{{ old('email') }}" required>
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
    @if(isset($recaptcha))
        <p class="text text-danger">We've detected unusual request activity from your IP address
            of {{ Request::getClientIp() }}. You'll need to prove that youre not a robot</p>
        @include('_partials.forms.authentication.recaptcha')
    @endif
    <hr/>
    <button class="btn btn-primary btn-block" type="submit">
        <i class="fa fa-plus"></i>&nbsp; Create My Account
    </button>
    <hr/>
</form>

<a href="{{ route('help.article.view', ['article' => 9, 'popup' => true]) }}" data-help>
    I don't know how to create my account
</a>
<hr/>
