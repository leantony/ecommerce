<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::model($brand,['url' => action('Backend\BrandsController@update', ['id' => $brand->id]), 'method' => 'PATCH', 'files' => true, 'data-remote']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Add a brand</h4>

                <div class="msgDisplay m-t-10"></div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', "Brand Name:", []) !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a brand name']) !!}
                    @if($errors->has('name'))
                        <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="row">
                    @if(empty($brand->logo))
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('logo', "Select a logo, that represents the manufacturer/brand. must be in PNG format (MAX SIZE, 1MB):", []) !!}
                                {!! Form::file('logo', ['class' => 'form-control']) !!}
                                @if($errors->has('logo'))
                                    <span class="wow flash error-msg">{{ $errors->first('logo') }}</span>
                                @endif
                            </div>
                        </div>
                    @else

                        <div class="col-md-12">
                            <h3>Current logo</h3>
                            <img src="{{ asset($brand->logo) }}" class="img-responsive img-thumbnail">
                            <hr/>
                            <div class="form-group">
                                {!! Form::label('logo', "Select a logo, that represents the manufacturer/brand. must be in PNG format (MAX SIZE, 1MB):", []) !!}
                                {!! Form::file('logo', ['class' => 'form-control']) !!}
                                @if($errors->has('logo'))
                                    <span class="wow flash error-msg">{{ $errors->first('logo') }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-close"></i>&nbsp;Close
                    </button>
                </div>
                <div class="pull-left">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus-circle"></i>&nbsp;Add Brand
                    </button>
                    <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>