<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::model($user, ['url' => route($route), 'method' => 'PATCH', 'files' => true, 'data-remote']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Add more information about yourself: </h4>
                @if($user->hasAddedAccountData())
                    <p class="text text-info">(You've done this already. The form fields have been filled for you)</p>
                @endif
            </div>
            <div class="modal-body">
                <div class="msgDisplay"></div>

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

                <div class="form-group">
                    <p>Your current profile picture</p>
                    @if(file_exists_on_server($user->avatar))
                        <div class="current-image">
                            <a data-lightbox="image-1" data-title="{{ $user->present()->fullName }}"
                               href="{{ display_img($user, 'avatar') }}">
                                <img style="height: 128px; width:128px" src="{{ display_img($user, 'avatar') }}"
                                     class="img-responsive img-thumbnail img-circle">
                            </a>
                        </div>
                    @else
                        <div>
                            <p class="text bold">
                                No profile picture yet
                            </p>
                        </div>
                    @endif
                    <p class="m-t-10">You can upload a new profile picture/avatar here</p>
                    <input type="file" name="avatar">
                    @if($errors->has('avatar'))
                        <p class="error_msg">{{ $errors->first('avatar') }}</p>
                    @endif
                </div>

                <br/>
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