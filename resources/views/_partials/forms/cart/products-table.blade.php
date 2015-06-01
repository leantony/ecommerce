<div class="msgDisplay m-t-10"></div>
<p class="bold">All prices are inclusive of a {{ config('site.products.VAT', .16) * 100 }} &percnt; VAT
    charge</p>
<table class="table table-bordered table-responsive table-condensed products-in-cart">

    <thead>
    <tr>
        <th>
            <h4>Product</h4>
        </th>
        <th>
            <h4>Description</h4>
        </th>
        <th>
            <h4>Qty</h4>
        </th>
        <th>
            <h4>Price</h4>
        </th>
        <th>
            <h4>VAT
                <br/><span class="text-small">(already included in price)</span></h4>
        </th>
        <th>
            <h4>Total</h4>
        </th>

    </tr>
    </thead>
    <tbody>
    @foreach($cart['products'] as $product)
        <tr>
            <td>
                <a href="{{ route('product.view', ['product' => $product['id'], ]) }}">
                    <img src="{{ display_img(null, $product['image']) }}" class="img-responsive small-image">
                </a>

            </td>
            <td>
                <p class="name">
                    <a href="{{ route('product.view', ['product' => $product['id'], ]) }}">
                        {{ $product['name'] }}
                    </a>
                </p>

                <p class="text text-primary bold">SKU:&nbsp;{{ $product['sku'] }}</p>
                <br/>

                <p>
                    Product arrives in: 1-3 business days&nbsp;&nbsp;.
                    <a href="{{ route('help.article.view', ['article' => 6, 'popup' => true]) }}" data-help
                       data-height="450" data-width="450">Why?</a>
                </p>
            </td>
            <td>
                <form method="POST" action="{{ route('cart.update', ['product' => $product['id']]) }}"
                      class="form-horizontal" role="form" {{ $useAjax ? "data-remote" : "" }}>
                    {!! Form::token() !!}
                    {!! Form::hidden('_method', 'PATCH') !!}
                    <input name="quantity" type="number"
                           value="{{ $product['quantity'] }}"
                           min="1" max="{{ $product['available'] }}" class="form-control pull-left"
                           style="width: 70px" required>
                    {!! Form::hidden('qt', $product['available']) !!}
                    <button class="btn btn-primary btn-sm pull-right" type="submit"
                            data-toggle="tooltip" data-placement="top"
                            data-original-title="update product quantity"
                            style="margin-top: 2px">
                        <i class="glyphicon glyphicon-refresh"></i>&nbsp;Update
                    </button>
                </form>

            </td>
            <td>
                <p>{{ format_money($product['total_price']) }}</p>
            </td>
            <td>
                <p>{{ format_money($product['VAT']) }}</p>
            </td>
            <td>
                <p class="bold">{{ format_money($product['total_price']) }}</p>
            </td>
            <td>
                <form method="POST"
                      action="{{ route('cart.update.remove', ['product' => $product['id']]) }}"
                      class="form-horizontal" {{ $useAjax ? "data-remote" : "" }}>
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::token() !!}
                    <button class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip"
                            data-placement="top" data-original-title="remove product from cart">
                        <i class="fa fa-trash-o"></i>&nbsp;Remove
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>