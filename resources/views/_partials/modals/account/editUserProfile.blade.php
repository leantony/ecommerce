<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::model($user, ['url' => route($route), 'method' => 'PATCH', 'files' => true, 'data-remote']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Change your personal information: </h4>
            </div>
            <div class="modal-body">
                <p>The form is currently filled in with your current values. Feel free to change them</p>

                <div class="msgDisplay"></div>
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" maxlength="20"
                           placeholder="Enter your first name"
                           value="{{ isset($user) ? $user->first_name : old('first_name') }}" required>
                    @if($errors->has('first_name'))
                        <span class="wow flash error-msg">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="last_name">Second Name:</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" maxlength="20"
                           placeholder="Enter your second name"
                           value="{{ isset($user) ? $user->last_name : old('last_name') }}" required>
                    @if($errors->has('last_name'))
                        <span class="wow flash error-msg">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="county_id">Select a county:</label>
                    {!! Form::select('county_id', str_replace('_', ' ', App\Models\County::lists('name', 'id')->all()), null,  [ 'class'=>'form-control', 'id' => 'county-input']) !!}
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
                @if(!empty($user->gender))
                    <div class="form-group">
                        {!! Form::label('gender', "Gender:", []) !!}
                        <br/>
                        {!! Form::radio('gender', 'Male', isset($user) & eq($user->gender, 'Male') ? true : false, []) !!}
                        Male
                        <br/>
                        {!! Form::radio('gender', 'Female', isset($user) & eq($user->gender, 'Female') ? true : false, []) !!}
                        Female

                        <br/>
                        @if($errors->has('gender'))
                            <span class="wow flash error-msg">{{ $errors->first('gender') }}</span>
                        @endif
                    </div>
                @endif
                @if(!empty($user->avatar))
                    <div class="form-group">
                        <p>Your profile picture</p>
                        @if(file_exists_on_server($user->avatar))
                            <div class="current-image">
                                <a data-lightbox="image-1" data-title="{{ $user->present()->fullName }}"
                                   href="{{ display_img($user, 'avatar') }}">
                                    <img style="height: 80px; width:80px" src="{{ display_img($user, 'avatar') }}"
                                         class="img-responsive">
                                </a>
                            </div>
                        @else
                            <div>
                                <p class="text">
                                    NONE
                                </p>
                            </div>
                        @endif
                        <p class="m-t-10">You can upload a new profile picture/avatar here</p>
                        <input type="file" name="avatar">
                        @if($errors->has('avatar'))
                            <p class="error_msg">{{ $errors->first('avatar') }}</p>
                        @endif

                    </div>
                @endif
                <br/>
                @if(!empty($user->dob))
                    <label for="dob">Date of Birth</label>

                    <div class="input-group date dateOfBirthDatetimePicker">
                        <input type="text" class="form-control" name="dob" placeholder="MM/DD/YYYY"
                               value="{{ isset($user) ? $user->dob : old('dob') }}"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    @if($errors->has('dob'))
                        <span class="wow flash error-msg">{{ $errors->first('dob') }}</span>
                    @endif
                    <br/>
                @endif

                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="Enter email address" value="{{ isset($user) ? $user->email : old('email') }}"
                           required>
                    @if($errors->has('email'))
                        <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="phone">Phone number:</label>

                    <div class="input-group">
                        <span class="input-group-addon">+254</span>
                        <input type="text" id="phone" name="phone" placeholder="712345678" maxlength="9" required
                               value="{{ isset($user) ? $user->phone : old('phone') }}" class="form-control">
                    </div>
                    @if($errors->has('phone'))
                        <span class="wow flash error-msg">{{ $errors->first('phone') }}</span>
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
                <div class="pull-left">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>&nbsp;Save</button>
                    &nbsp;<span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;cancel
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
