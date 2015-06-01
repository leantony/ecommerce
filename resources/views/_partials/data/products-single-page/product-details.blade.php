<div class="row   m-b-20">
    <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
        <div class="product-item-holder size-big single-product-gallery small-gallery">

            <div id="owl-single-product">
                <div class="single-product-gallery-item" id="slide1">
                    <a data-lightbox="image-1" data-title="{{ $product->name . " images" }}"
                       href="{{ !$product->zoomable ? display_img($product, 'image_large') : display_img($product)  }}">
                        <img class="img-responsive product-detail-image"
                             src="{{ display_img($product) }}"
                        @if($product->zoomable)
                             id="zoom_img" data-zoom-image="{{ asset($product->image_large) }}"
                                @endif
                                />
                    </a>
                </div>
                <span class="text text-center">
                    @if($product->zoomable)
                        <i class="fa fa-search-plus"></i>
                        Roll over the image to zoom
                    @else
                        <i class="glyphicon glyphicon-info-sign"></i>
                        Image zoom is not available
                    @endif
                </span>
            </div>

        </div>
    </div>
    <div class="col-sm-6 col-md-7 product-info-block">
        <div class="product-info">
            <h4>{{ $product->name }}</h4>

            <div class="rating-reviews m-t-10">
                @if(empty($reviewCount))
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="rating">
                                <span class="text text-primary bold">Rating:&nbsp;</span>
                                <span class="text text-info">Not reviewed Yet</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-sm-12">
                            <?php $stars = $product->getAverageRating(); ?>
                            <div class="rating">
                                <span class="text text-primary bold">Rating:&nbsp;</span>
                                <input type="hidden" class="rating" readonly data-fractions="2"
                                       value={{ $stars }}/>
                                                            <span class="text text-info text-small">
                                                                <a href="#reviews" class="lnk" data-open-tab>
                                                                    ({{ $reviewCount }})
                                                                    {{ $reviewCount > 1 ? str_plural('review') : str_singular('review') }}</a>
                                                            </span>
                            </div>
                        </div>
                    </div>

                    @endif
                            <!-- /.row -->
            </div>
            <!-- /.rating-reviews -->
            <div class="stock-container info-container m-t-5">
                <div class="row">
                    <div class="col-sm-12">
                        <span class="text text-primary bold">
                                                    Sub category: &nbsp;
                                                </span>
                                                <span class="text text-info">
                                                    <a href="{{ route('subcategories.shop', ['id' => $product->subcategory->id ]) }}">
                                                        {{ beautify($product->subcategory->name) }}
                                                    </a>

                                                </span>
                        <br/>
                    </div>
                    <div class="col-sm-12 m-t-5">
                                            <span class="text text-primary bold">
                                                    Manufacturer: &nbsp;
                                                </span>
                                                <span class="text text-info">
                                                    <a href="{{ route('brands.shop', ['brand' => $product->brand->id]) }}">
                                                        {{ beautify($product->brand->name) }}
                                                    </a>

                                                </span>
                        <br/>
                    </div>
                </div>
                <div class="row m-t-5">
                    <div class="col-sm-6">
                        <div class="stock-box">
                            <span class="text text-primary bold">Availability: &nbsp;</span>
                            @if($stockUnavailable)
                                <span class="text text-danger">Out of stock</span>
                            @else
                                <span class="value">In Stock</span>
                                @if($product->needsStockWarning())
                                    <span class="text text-danger">
                                                        (only {{ $product->quantity }} left)
                                                    </span>
                                @elseif(config('site.products.quantity.display', false))
                                    <span class="text text-success">
                                                        ({{ $product->quantity }}) items
                                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($product->sku))
                <div class="m-t-5">
                    <span class="text text-primary bold">SKU:&nbsp;</span> {{ $product->sku }}
                </div>
            @endif
            <div class="description-container m-t-20 force-list-style">
                <span class="text text-primary bold">Specifications :</span>
                {!! $product->description_short !!}
            </div>
        </div>
    </div>
</div>