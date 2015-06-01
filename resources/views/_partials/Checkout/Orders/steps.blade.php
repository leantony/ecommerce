@if($is_logged_in)
    @include('_partials.Checkout.checkout-progress.step1', ['state' => 'disabled', 'route' => route('checkout.step1')])
    @include('_partials.Checkout.checkout-progress.step2', ['state' => 'complete', 'route' => route('u.checkout.step2')])
    @include('_partials.Checkout.checkout-progress.step3', ['state' => 'complete', 'route' => route('u.checkout.step3')])
    @include('_partials.Checkout.checkout-progress.step4', ['state' => 'active', 'route' => route('u.checkout.step4')])
@else

    @include('_partials.Checkout.checkout-progress.step1', ['state' => 'complete', 'route' => route('checkout.step1')])
    @include('_partials.Checkout.checkout-progress.step2', ['state' => 'complete', 'route' => route('checkout.step2')])
    @include('_partials.Checkout.checkout-progress.step3', ['state' => 'complete', 'route' => route('checkout.step3')])
    @include('_partials.Checkout.checkout-progress.step4', ['state' => 'active', 'route' => route('checkout.step4')])
@endif
