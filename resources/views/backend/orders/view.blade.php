@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Orders</title>
@stop

@section('content')

    @if(Request::get('guest') == 1)
        <h3>Product Order made by {{ $order->guests->implode('first_name') .' '. $order->guests->implode('last_name') }}</h3>
    @else
        <h3>Product Order made by {{ $order->users->implode('first_name') .' '. $order->users->implode('last_name') }}</h3>
    @endif
    <p>This section displays details about an order made</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.orders.index') }}">
                    <button class="btn btn-success">
                        Back
                    </button>
                </a>
            </div>
        </div>

        <div class="col-md-12 m-t-20">
            <hr/>
            <p>This order was made on {{ $order->created_at }} ({{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }})</p>
            <p>This order has {{ $order->delivered ? "been delivered" : "not been delivered yet" }}</p>
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
                @foreach($order->data['products'] as $product)
                    <tr>
                        <td>
                            <a href="{{ route('backend.products.edit', ['product' => $product['id']]) }}">
                                <img src="{{ display_img(null, $product['image']) }}" class="img-responsive small-image">
                            </a>

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
                    <td>{{ format_money($order->data['cart']['basket_total'])  }}</td>
                </tr>
                <tr>
                    <th class="bold">Shipping & handling:</th>
                    <td>{{ format_money($order->data['cart']['shipping']) }}</td>
                </tr>
                <tr>
                    <th>
                        <h4 class="bold">
                            Order total:
                        </h4>
                    </th>
                    <td>
                        <h4>
                            {{ format_money($order->data['cart']['grand_total']) }}
                        </h4>
                    </td>
                </tr>
            </table>
        </div>

    </div>
@stop