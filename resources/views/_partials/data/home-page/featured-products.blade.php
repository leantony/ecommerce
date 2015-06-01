<div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
    @foreach($data as $product)
        <div class="item item-carousel">
            <div class="products">
                <div class="product">
                    <h4 class="text-center">
                                    <span class="label label-info brand-label">
                                        <a href="{{ route('brands.shop', ['brand' => $product->brand->id]) }}">
                                            {{ $product->brand->name }}
                                        </a>
                                    </span>
                    </h4>

                    <div class="product-image">
                        <div class="image p-all-10">
                            <a href="{{ route('product.view', ['product' => $product->id, ]) }}">
                                <img src="{{ empty_image() }}"
                                     class="img-thumbnail img-responsive {{ isset($imgSizeClass) ? $imgSizeClass : "product-image-general" }}"
                                     data-echo={{ display_img($product) }}>
                            </a>
                        </div>
                        <!-- /.image -->
                    </div>
                    <!-- /.product-image -->
                    <div class="product-info text-left p-all-10">
                        <div class="p-name">
                            <p>
                                <a href="{{ route('product.view', ['product' => $product->id, ]) }}">
                                    {{ $product->name }}
                                </a>
                            </p>
                        </div>


                        <?php $reviewCount = $product->getSingleProductReviewCount(); ?>
                        @if(empty($reviewCount))
                            <div class="rating {{ isset($ratingClass) ? $ratingClass : "" }}">
                                <span class="text-primary bold">Rating:&nbsp;None</span>
                            </div>
                        @else
                            <div class="rating">
                                <?php $stars = $product->getAverageRating(); ?>
                                <div class="rating {{ isset($ratingClass) ? $ratingClass : "" }}">
                                    <span class="text text-primary bold">Rating:&nbsp;</span>
                                    <input type="hidden" class="rating" readonly data-fractions="2"
                                           value={{ $stars }}/>
                                                <span class="text text-info text-small">
                                                    ({{ $reviewCount }})
                                                    {{ $reviewCount > 1 ? str_plural('review') : str_singular('review') }}
                                                </span>
                                </div>
                            </div>
                        @endif

                        <div class="product-price {{ isset($priceClass) ? $priceClass : "" }}">
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

                    </div>
                    <!-- /.product-info -->
                    <div class="cart-section p-all-10">
                        <div class="action">
                            <ul class="list-unstyled">

                                <li class="add-cart-button btn-group">
                                    {!! Form::open(['url' => route('cart.add', ['product' => $product->id]), 'data-remote']) !!}
                                    {!! Form::input('hidden', '_qt', $product->quantity) !!}
                                    <button type="submit"
                                            class="btn btn-primary {{ $product->hasRanOutOfStock() ? "disabled" : "" }}">
                                        <i class="glyphicon glyphicon-shopping-cart inner-right-vs"></i> ADD
                                        TO CART
                                    </button>
                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </div>
                        <!-- /.action -->
                    </div>
                    <!-- /.cart -->
                </div>
                <!-- /.product -->
            </div>
            <!-- /.products -->
        </div>
        @endforeach
                <!-- /.item -->
</div>