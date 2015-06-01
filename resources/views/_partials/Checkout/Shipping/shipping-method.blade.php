<div class="well">
    <p class="bold">Home delivery
        to {{ $data->home_address }}: <span
                class="text-info">{{  format_money($cart['cart']['shipping']) }}</span></p>

    <p class="text-info">{{ $cart['cart']['shipping'] === 0 ? "Shipping is free for this item(s)" : "Shipping is not free for this item(s)"}}</p>
</div>