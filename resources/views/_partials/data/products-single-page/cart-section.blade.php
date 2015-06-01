<div class="product-social-link text-right">
    <div class="social-icons">
        <ul class="list-inline">
            <li>
                <span class="social-label">Share :</span>
            </li>

            <li><a class="fa fa-facebook" href="#"></a></li>
            <li><a class="fa fa-twitter" href="#"></a></li>
            <li><a class="glyphicon glyphicon-envelope" href="#"></a></li>
            <li><a class="fa fa-pinterest" href="#"></a></li>
        </ul>
        <!-- /.social-icons -->
    </div>
    <hr/>

    <table class="table table-responsive">
        {!! Form::open(['route' => ['cart.add', $product->id], 'data-remote']) !!}
        <tr>
            <th>
                Qty:
            </th>
            <td>

                @if($product->needsTextInputForQuantity())
                    {!! Form::selectRange('quantity', 1, $product->quantity, 1, ['class' => 'form-control pull-left', 'style' => 'width:80px']) !!}
                @else
                    <input name="quantity" type="number" min="1"
                           max="{{ $product->quantity }}" class="form-control pull-left"
                           style="width: 80px">
                @endif
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <div class="">
                    @if(!$product->hasDiscount())
                        <span class="price bold-lg pull-right">{{ format_money($product->total()) }}</span>
                    @else
                        <span class="discounted-product-old-price pull-left">{{  format_money($product->valuePlusTax()) }}</span>
                        &nbsp;
                        <span class="price bold-lg pull-right">{{ format_money($product->total()) }}</span>

                        <hr/>
                        <div class="m-t-5">
                            <p>This product has a <span
                                        class="text text-info">{{ $product->getDiscountRate(true) }}</span>
                                discount</p>

                            <p>
                                You save: <span class="text text-info">{{ $product->getDiscountAmount() }}</span>
                            </p>

                        </div>
                    @endif
                </div>

            </td>
        </tr>
        <tr class="m-t-40">
            <th></th>
            <td>
                @if($product->needsStockWarning())
                    <div class="alert alert-warning">
                        <p class="text text-justify"><i class="fa fa-warning"></i>&nbsp;This product is almost running
                            out of stock.</p>
                    </div>
                @endif
                @if($stockUnavailable)
                    <div class="alert alert-warning">
                        <p class="text text-justify"><i class="fa fa-warning"></i>&nbsp;This product is currently out of
                            stock.</p>
                    </div>
                @endif
                {!! Form::input('hidden', 'qt', $product->quantity) !!}
                <button type="submit"
                        class="btn btn-primary btn-block btn-uppercase {{ $stockUnavailable ? "disabled" : "" }}">
                    <i class="glyphicon glyphicon-shopping-cart inner-right-vs"></i> add to cart
                </button>
                {!! Form::close() !!}
            </td>
        </tr>

    </table>
</div>