@include('_partials.site-logo', ['unstyled' => false])
<h2>Your Invoice {{ isset($copy) ? "(copy)" : "" }}</h2>

<h3>Order # {{ $order->id }}</h3>
<hr/>