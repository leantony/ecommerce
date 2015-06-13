@if(($product->reviews->isEmpty()))
    <div class="alert alert-warning">
        <p>This product hasn't been reviewed yet. You are welcome to add
            your review</p>
    </div>

    @if($is_logged_in & !$reviewed)
        <a href="#" data-toggle="modal" data-target="#reviewProduct">
            <button class="btn btn-primary">
                <i class="fa fa-plus"></i>&nbsp;Add my review
            </button>
        </a>
    @else
        <div class="p-all-10" style="border: 1px solid #E3E3E3">
            <p>{!! link_to_auth_route('login', app('url')->current()) !!}
                or {!! link_to_auth_route('register', app('url')->current(), 'Register', []) !!} today, to
                be able to add your reviews about a product
            </p>
        </div>

    @endif
@else
    @if($is_logged_in)
        @if($product->reviews->count() >= config('site.products.reviews.display', 5))
            <?php
            $exceeded = true;
            $data = $product->grabReviews($auth_user, config('site.products.reviews.display', 5));
            ?>
        @else
            <?php $data = $product->grabReviews($auth_user, config('site.products.reviews.display', 5));
            ?>
        @endif

    @else
        @if($product->reviews->count() >= config('site.products.reviews.display', 5))
            <?php
            $exceeded = true;
            $data = $product->grabReviews(null, config('site.products.reviews.display', 5));
            ?>
        @else
            <?php $data = $product->grabReviews(null, config('site.products.reviews.display', 5));
            ?>
        @endif
        <div class="p-all-10" style="border: 1px solid #E3E3E3">
            <p>{!! link_to_auth_route('login', app('url')->current()) !!}
                or {!! link_to_auth_route('register', app('url')->current(), 'Register', []) !!} today, to
                be able to add your reviews about a product
            </p>
        </div>
    @endif
    <div class="row rating-breakdown">
        <div class="col-xs-12 col-md-12">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-xs-12 col-md-6 text-center">
                        <h4 class="rating-num">
                            {{ round($stars, 1) }}
                        </h4>

                        <div class="rating">
                            <input type="hidden" class="rating"
                                   readonly data-fractions="2"
                                   value={{ $stars }}/>
                        </div>
                        <div>
                            <span class="glyphicon glyphicon-user"></span>{{ $reviewCount }}
                            total
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($reviewed)
        <?php $user_review = $auth_user->retrieveUserReview($product->id) ?>
        <div class="row current-user-review">
            <h3>Your review</h3>
            @foreach($user_review as $review)
                <div class="pull-left col-md-2">
                    <img class="media-object img-circle display-user-avatar"
                         src="{{ empty($review->user->avatar) ? default_user_avatar() : $review->user->avatar }}">
                </div>
                <div class="pull-right col-md-10">
                    <h4>
                        {{ $auth_user->present()->fullName }}
                    </h4>
                    On <span
                            class="bold">{{ $review->created_at }}</span>
                    <br/>

                    <div class="rating">
                        <input type="hidden" class="rating"
                               readonly
                               data-fractions="2"
                               value={{ $review->stars }}/>
                    </div>
                    <p class="media-comment">
                        {{ $review->comment }}
                        <br/>
                                                                    <span class="text text-info">(last updated on : {{ $review->updated_at }}
                                                                        )</span>
                    </p>
                    <a href="#" data-toggle="modal"
                       data-target="#editReview">
                        <button class="btn btn-primary"><i
                                    class="fa fa-edit"></i>&nbsp;
                            Edit review
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
        <hr/>
    @endif
    @if($is_logged_in & !$reviewed)
        <a href="#" data-toggle="modal" data-target="#reviewProduct">
            <button class="btn btn-primary">
                <i class="fa fa-plus"></i>&nbsp;Add my review
            </button>
        </a>
        <hr/>
    @endif
    @foreach($data as $review)
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
@endif
@if(isset($exceeded))
    <a href="#" data-toggle="modal" data-target="#viewAll">
        <button class="btn btn-primary center-block">
            <i class="fa fa-arrow-circle-o-right"></i>&nbsp;
            view all {{ $product->reviews->unique()->count() }} reviews
        </button>
    </a>

    @include('_partials.modals.reviews.view-all', ['elementID' => 'viewAll'])
@endif
@if(isset($user_review))
    @include('_partials.modals.reviews.editReview', ['elementID' => 'editReview'])
@endif