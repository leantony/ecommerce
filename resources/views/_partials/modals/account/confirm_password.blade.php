<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['url' => route('confirm_password', ['proceedTo' => app('url')->current()]), $useAjax ? "data-remote" : ""]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Password confirmation</h4>

                <p>Before you proceed, you will need to provide your password</p>
            </div>
            <div class="modal-body">
                <div class="msgDisplay"></div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="confirm your password" required data-toggle="password">
                    @if($errors->has('password'))
                        <span class="wow flash error-msg">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>&nbsp;Verify
                    </button>
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