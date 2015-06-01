<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::model($county, ['url' => action('Backend\CountiesController@update', ['id' => $county->id]), 'method' => 'PATCH', 'id' => 'countiesEditForm', 'data-remote']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Edit details of <strong>{{ $county->name }}</strong> county
                </h4>

                <div class="msgDisplay m-t-10"></div>
            </div>
            <div class="modal-body">
                <div class="form-ajax-result"></div>
                <div class="form-group">
                    {!! Form::label('name', "County Name:", []) !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a county name']) !!}
                    @if($errors->has('name'))
                        <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('alias', "County Alias (just a short name):", []) !!}
                    {!! Form::text('alias', null, ['class' => 'form-control', 'placeholder' => 'eg, NRB for nairobi']) !!}
                    @if($errors->has('alias'))
                        <span class="wow flash error-msg">{{ $errors->first('alias') }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close
                    </button>
                </div>
                <div class="pull-left">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check-square"></i>&nbsp;Finish Edit
                    </button>
                    <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>