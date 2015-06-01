@if($ignoreParentDiv)

    @include('_partials.forms.cart.products-table', ['useAjax' => $useAjax])
@else
    <div class="col-md-12 m-b-20">
        @include('_partials.forms.cart.products-table', ['useAjax' => $useAjax])
    </div>

@endif

<hr/>
<div class="col-md-4 m-b-10">
    @if($includePromoSection)
        <p>Do you have a voucher/promotional code? Redeem it here</p>
        @include('_partials.Checkout.payment.redeem-promo')
    @endif

</div>
@if($displayOrderSummary)
    <div class="col-md-5 col-md-offset-3 m-b-10">
        <table class="table table-bordered">
            <tr>
                <th class="bold">Total cost:</th>
                <td>{{ format_money($cart['cart']['basket_total']) }}</td>
            </tr>
            <tr>
                <th class="bold">Shipping & handling:</th>
                <td>{{ format_money($cart['cart']['shipping']) }}</td>
            </tr>
            <tr>
                <th>
                    <h4 class="bold">
                        Estimated order total:
                    </h4>
                </th>
                <td>
                    <h4>
                        {{ format_money($cart['cart']['grand_total']) }}
                    </h4>
                </td>
            </tr>
        </table>
    </div>
@endif