<table class="table table-bordered">
    <tr>
        <th class="bold">Promo code:</th>
        <td>
            <input type="text" class="form-control" id="promoCode" required placeholder="Enter code">
        </td>
        <td>
            <button type="submit" class="btn btn-primary">Apply</button>
        </td>
    </tr>
    @if(isset($voucher))
        <tr>
            <th class="bold">Voucher code:</th>
            <td>
                <input type="text" class="form-control" id="voucherCode" required placeholder="Enter code">
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Apply</button>
            </td>
        </tr>
    @endif
</table>