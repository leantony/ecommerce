<?php $related = $product->getRelated()?>
@if($related->isEmpty())
    <div class="p-all-10 alert alert-info">
        <p>There are no related products</p>
    </div>
@else
    <div class="p-all-10">
        @foreach($related as $product)
            <div class="row">
                <div class="col-md-4">

                    <a href="{{ route('product.view', ['product' => $product->id, ]) }}">
                        <img src="{{ display_img($product) }}"
                             class="img-responsive img-thumbnail related-product-image">
                    </a>

                </div>

                <div class="col-md-8">

                    <a href="{{ route('product.view', ['product' => $product->id, ]) }}">

                        {{ str_limit($product->name, 40) }}

                    </a>
                    <?php $reviewCount = $product->getSingleProductReviewCount(); ?>
                    @if(empty($reviewCount))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="rating text-small">
                                    <span class="text text-primary bold">Rating:&nbsp;</span>
                                    <!-- http://ecomm.pc-world.com/products/52#comments-tab -->
                                    <span class="text text-info">Not reviewed Yet</span>
                                </div>
                            </div>
                        </div><!-- /.row -->
                    @else
                        <div class="row">
                            <div class="col-sm-12">
                                <?php $stars = $product->getAverageRating(); ?>
                                <div class="rating">
                                    <input type="hidden" class="rating" readonly data-fractions="2"
                                           value={{ $stars }}/>
                                                            <span class="text text-info text-small">
                                                                    ({{ $reviewCount }})
                                                                {{ $reviewCount > 1 ? str_plural('review') : str_singular('review') }}
                                                            </span>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>

            </div>
            <hr/>

        @endforeach
    </div>

@endif

