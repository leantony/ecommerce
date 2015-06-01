<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID }}Label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => ['product.reviews.update', 'id' => $user_review->implode('id')], 'class' => 'editMyComment', 'data-remote', 'id' => 'reviewsForm', 'method' => 'PATCH']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    Edit your review
                </h4>

                <div class="msgDisplay m-t-10"></div>
            </div>
            <div class="modal-body p-all-10">
                <div class="form-group rating">
                    <label for="stars"><span class="text text-primary"> New Rating:</span></label>
                    <input id="stars" name="stars" type="hidden" class="rating form-control" data-fractions="2"
                           data-stop="{{ max_star_rating() }}" data-start="0.5"
                           value="{{ $user_review->implode('stars') }}"/>
                </div>
                <div class="form-group">
                    <label for="comment">Modify comment:</label>
                    {!! Form::textarea('comment', $user_review->implode('comment'), ['rows' => '4', 'class' => 'form-control', 'placeholder' => 'Enter a comment', 'required']) !!}
                </div>

            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close
                    </button>
                </div>
                <div class="pull-left">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check-square"></i>&nbsp;Save
                    </button>
                    <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>