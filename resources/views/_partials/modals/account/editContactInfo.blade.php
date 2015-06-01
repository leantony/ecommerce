<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" action="{{ route($route) }}" id="contactsEditForm" data-remote>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="infoModalLabel">Change your contact information: </h4>
                </div>
                <div class="modal-body">
                    <p>The form is currently filled in with your current values. Feel free to change them</p>

                    <div class="msgDisplay"></div>
                    <input type="hidden" name="_method" value="PATCH">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <label for="phone">Phone number:</label>

                        <div class="input-group">
                            <span class="input-group-addon">+254</span>
                            <input type="text" id="phone" name="phone" maxlength="9" required
                                   value="{{ isset($user) ? $user->phone : old('phone') }}" class="form-control">
                        </div>
                        @if($errors->has('phone'))
                            <span class="wow flash error-msg">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email"
                               value="{{ isset($user) ? $user->email : old('email') }}" name="email" required>
                        @if($errors->has('email'))
                            <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <br/>

                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>&nbsp;Save
                        </button>
                        &nbsp;<span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>