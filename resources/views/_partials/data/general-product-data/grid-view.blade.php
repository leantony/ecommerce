<div class="tab-pane" id="grid-container">
    <div class="category-product   inner-top-vs">
        <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 m-b-20">
                    <div class="products">
                        <div class="product">
                            <div class="product-image m-b-20">
                                <div class="image">
                                    <a href="{{ route('product.view', ['product' => $product->id, ]) }}">
                                        <img src="{{ empty_image() }}"
                                             class="img-responsive img-thumbnail product-image-general"
                                             data-echo={{ display_img($product) }}>
                                    </a>
                                </div>
                                <!-- /.image -->

                                @if($product->isNew())
                                    <div class="tag new">
                                        <span>new</span>
                                    </div>
                                @endif
                                @if($product->isHot())
                                    <div class="tag hot">
                                        <span>Hot</span>
                                    </div>
                                @endif
                            </div>
                            <!-- /.product-image -->
                            <div class="product-info text-left">
                                <div class="p-name">
                                    <h5>
                                        <a href="{{ route('product.view', ['product' => $product->id, ]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                </div>
                                <?php $reviewCount = $product->getSingleProductReviewCount(); ?>
                                @if(!empty($reviewCount))
                                    <?php $stars = $product->getAverageRating(); ?>
                                    <div class="rating">
                                        <input type="hidden" class="rating" readonly
                                               data-fractions="2" value={{ $stars }}/>
                                                                            <span class="text text-info text-small">
                                                                                ({{ $product->getSingleProductReviewCount() }} {{ $reviewCount > 1 ? str_plural('review') : str_singular('review') }}
                                                                                )
                                                                            </span>
                                    </div>
                                @else
                                    <div class="rating">
                                        <span class="text text-muted">Rating: </span>
                                        <!-- http://ecomm.pc-world.com/products/52#comments-tab -->
                                        <span class="text text-info">(Not rated Yet)</span>
                                    </div>
                                @endif
                                <div class="product-price m-t-10 m-b-10">
                                    @if(!$product->hasRanOutOfStock())
                                        @if(!$product->hasDiscount())
                                            <span class="price">{{ format_money($product->total()) }}</span>
                                        @else
                                            <span class="discounted-product-old-price">{{  format_money($product->valuePlusTax()) }}</span>
                                            &nbsp;
                                            <span class="price">{{ format_money($product->total()) }}</span>
                                        @endif
                                    @else
                                        <p class="text text-danger">Out of stock</p>
                                    @endif
                                </div>
                                <div class="description m-t-10 product-desc">
                                    <div class="fixed-height">
                                        {!! $product->description_short !!}
                                    </div>
                                </div>
                            </div>
                            <!-- /.product-info -->
                            <div class="cart clearfix animate-effect">
                                <div class="action m-t-10">
                                    <ul class="list-unstyled">
                                        <li class="add-cart-button btn-group">
                                            {!! Form::open(['route' => ['cart.add', $product->id], 'data-remote']) !!}
                                            {!! Form::input('hidden', 'qt', $product->quantity) !!}
                                            <button type="submit"
                                                    class="btn btn-primary {{ $product->hasRanOutOfStock() ? "disabled" : "" }}">
                                                <i class="glyphicon glyphicon-shopping-cart inner-right-vs"></i>
                                                ADD TO CART
                                            </button>
                                            {!! Form::close() !!}

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>