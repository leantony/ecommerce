<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::model($subcategory, ['url' => action('Backend\SubCategoriesController@update', ['id' => $subcategory->id]), 'id' => 'SubCategoriesEditForm', 'method' => 'PATCH', 'data-remote']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Editing {{ $subcategory->name }}</h4>

                <div class="msgDisplay m-t-10"></div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Sub-category name</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a category name']) !!}
                    @if($errors->has('name'))
                        <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="alias">Sub-category Alias (just a short name)</label>
                    {!! Form::text('alias', null, ['class' => 'form-control', 'placeholder' => 'Enter a category alias']) !!}
                    @if($errors->has('alias'))
                        <span class="wow flash error-msg">{{ $errors->first('alias') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('category_id', "Pick a category:", []) !!}
                    {!! Form::select('category_id', App\Models\Category::lists('name', 'id')->all(), null, [ 'class'=>'form-control']) !!}
                    @if($errors->has('category_id'))
                        {{ $errors->first('category_id') }}
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
                        <i class="fa fa-plus-circle"></i>&nbsp;Finish edit
                    </button>
                    <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
