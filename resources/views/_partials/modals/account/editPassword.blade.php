<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="POST" action="{{ $route }}" id="simplePasswordResetForm"
                  data-remote>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="infoModalLabel">Reset your password here: </h4>
                </div>
                <div class="modal-body">
                    <p>Ensure that you provide a strong password. A strong password should consist of be at least 6
                        characters in length, and consist of symbols, letters and numbers</p>
                    <hr/>
                    <div class="msgDisplay"></div>
                    <input type="hidden" name="_method" value="PATCH">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <label for="password">New password:</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Enter your new password" required data-toggle="password">
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
                    @if(isset($logoutOption))
                        <div class="field-row form-group">
                            <input type="checkbox" name="logMeOut">
                            <span>Log me out, after I change my password (optional)</span>
                            <br/>
                        </div>
                    @endif

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