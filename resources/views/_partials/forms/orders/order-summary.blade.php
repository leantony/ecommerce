<h3>Order summary => {{ array_get($cart['cart'], 'total_products') }} item(s)</h3>

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
        <th class="bold">Total Tax (VAT): <br/><span
                    class="text-small text-info">(Already included in the total cost)</span></th>
        <td>{{ format_money($cart['cart']['VAT']) }}</td>
    </tr>
    <tr>
        <th>
            <h4 class="bold">
                Order total:
            </h4>
        </th>
        <td>
            <h4 class="bold">
                {{ format_money($cart['cart']['grand_total']) }}
            </h4>
        </td>
    </tr>
</table>