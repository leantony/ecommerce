<div class="col-md-10 col-md-offset-1">
    <p class="bold">All prices are inclusive of a {{ config('site.products.VAT', .16) * 100 }} &percnt;
        VAT
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
        @foreach($products_ as $product)
            <tr>
                <td>
                    <img src="{{ display_img(null, $product['image']) }}" class="img-responsive small-image">
                </td>
                <td>
                    <p class="name">
                        {{ $product['name'] }}
                    </p>

                    <p class="text text-primary bold">SKU:&nbsp;{{ $product['sku'] }}</p>
                </td>
                <td>
                    <p>
                        {{ $product['quantity'] }}
                    </p>
                </td>
                <td>
                    <p>{{ format_money($product['total_price']) }}</p>
                </td>
                <td>
                    <p>{{ format_money($product['VAT']) }}</p>
                </td>
                <td>
                    <p class="bold">{{ format_money($product['order_total']) }}</p>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table class="table table-bordered">
        <tr>
            <th class="bold">Total cost:</th>
            <td>{{ format_money($basket['basket_total'])  }}</td>
        </tr>
        <tr>
            <th class="bold">Shipping & handling:</th>
            <td>{{ format_money($basket['shipping']) }}</td>
        </tr>
        <tr>
            <th>
                <h4 class="bold">
                    Order total:
                </h4>
            </th>
            <td>
                <h4>
                    {{ format_money($basket['grand_total']) }}
                </h4>
            </td>
        </tr>
    </table>
    <h5 class="text text-info">Thank you for shopping with us!!.
        @if(!$orderHasArrived)
            Your product will arrive anytime, in 3
            days. If it takes longer than this, Please call us on +254705568254, or drop us an email, at
            support@pcworld.com.
        @else
            Your product was already been shipped to your destination.
        @endif

        You should Keep this invoice for accountability purposes.
    </h5>
</div>