<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Product reviews</h4>

                <p>{{ $product->name }}</p>
            </div>
            <div class="modal-body">
                @foreach($product->grabAllReviews() as $review)
                    <div class="row">
                        <div class="pull-left col-md-2">
                            <img class="media-object img-circle display-user-avatar"
                                 src="{{ empty($review->user->avatar) ? default_user_avatar() : $review->user->avatar }}">
                        </div>
                        <div class="pull-right col-md-10">
                            <h4>
                                {{ $review->user->present()->fullName }}
                            </h4>
                            On <span
                                    class="bold">{{ $review->created_at }}</span>
                            <br/>

                            <div class="rating">
                                <input type="hidden" class="rating" readonly
                                       data-fractions="2"
                                       value={{ $review->stars }}/>
                            </div>
                            <p class="media-comment">
                                {{ $review->comment }}
                            </p>
                        </div>
                    </div>
                    <hr/>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;close
                </button>
            </div>
        </div>
    </div>
</div>