@if($is_logged_in)
    <div class="m-t-10">
        <a href="{{ route('cart.view') }}">
            <button class="btn btn-warning pull-left">
                <i class="fa fa-arrow-left"></i>&nbsp;Back to Shopping cart
            </button>
        </a>
        <a href="{{ route('u.checkout.step3') }}">
            <button class="btn btn-success pull-right">
                Proceed to payment page&nbsp;<i class="fa fa-arrow-right"></i>
            </button>
        </a>
    </div>
@else

    <div class="m-t-10">
        <a href="{{ route('checkout.step1') }}">
            <button class="btn btn-warning pull-left">
                <i class="fa fa-arrow-left"></i>&nbsp;Back to billing address page
            </button>
        </a>
        <a href="{{ route('checkout.step3') }}">
            <button class="btn btn-success pull-right">
                Proceed to payment page&nbsp;<i class="fa fa-arrow-right"></i>
            </button>
        </a>
    </div>

@endif