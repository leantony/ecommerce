<div class="modal" id="{{ $elementID }}" tabindex="-1" role="dialog" aria-labelledby="{{ $elementID. "Label" }}"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="infoModalLabel">Viewing details for order # {{ $order->id }}</h4>
            </div>
            <div class="modal-body">
                <p>Your order contained the following products</p>
                <hr/>
                <div class="row m-t-20 m-b-10">
                    @foreach($order_data->products as $product)
                        <div class="col-md-8">
                            <h4 class="bold">Name</h4>

                            <p>
                                <a href="{{ route('product.view', ['product' => $product->id]) }}" target="_blank">
                                    {{ $product->name }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="bold">Cost</h4>

                            <p>{{ format_money($product->total()) }}</p>
                        </div>
                        <div class="col-md-2">
                            <h4 class="bold">Quantity</h4>

                            <p class="pull-right">{{ $order_data->getSingleProductQuantity($product) }}</p>
                        </div>
                        <br/>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;close
                </button>
            </div>
        </div>
    </div>
</div>