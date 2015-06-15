<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => action('Backend\UsersController@store'), 'id' => 'UsersAddForm', 'data-remote']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Create a User</h4>

                <div class="msgDisplay m-t-10"></div>
            </div>
            <div class="modal-body">
                <div class="form-ajax-result"></div>
                <div class="form-group">
                    {!! Form::label('first_name', "First Name:", []) !!}
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'firstname']) !!}
                    @if($errors->has('first_name'))
                        <span class="wow flash error-msg">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('last_name', "Last Name:", []) !!}
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'lastname']) !!}
                    @if($errors->has('last_name'))
                        <span class="wow flash error-msg">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('phone', "Phone Number:", []) !!}
                    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter a phone number']) !!}
                    @if($errors->has('phone'))
                        <span class="wow flash error-msg">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <h6>Pick a county</h6>
                    {!! Form::label('county_id', "County:", []) !!}
                    {!! Form::select('county_id', App\Models\County::lists('name', 'id')->all(), null, ['class' => 'form-control']) !!}
                    @if($errors->has('county_id'))
                        <span class="wow flash error-msg">{{ $errors->first('county_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('town', "Home town:", []) !!}
                    {!! Form::text('town', null, ['class' => 'form-control', 'placeholder' => 'Enter a town..eg nairobi']) !!}
                    @if($errors->has('town'))
                        <span class="wow flash error-msg">{{ $errors->first('town') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    {!! Form::label('home_address', "Home address:", []) !!}
                    {!! Form::textarea('home_address', null, ['rows' => '2', 'class' => 'form-control', 'placeholder' => 'Enter a random home address']) !!}
                    @if($errors->has('home_address'))
                        <span class="wow flash error-msg">{{ $errors->first('home_address') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('email', "Email Address:", []) !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter a email address']) !!}
                    @if($errors->has('email'))
                        <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                @if(isset($passwords))
                    <div class="form-group">
                        {!! Form::label('password', "Password:", []) !!}
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'just assign a random password']) !!}
                        @if($errors->has('password'))
                            <span class="wow flash error-msg">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', "Password confirmation:", []) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'repeat the password']) !!}
                        @if($errors->has('password_confirmation'))
                            <span class="wow flash error-msg">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-close"></i>&nbsp;Close
                    </button>
                </div>
                <div class="pull-left">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus-circle"></i>&nbsp;Add User
                    </button>
                    <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
