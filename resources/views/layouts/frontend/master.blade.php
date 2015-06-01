<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    @section('head')
        @include('layouts.frontend.sections.navigation.header')
    @show
</head>

<body>
@if(config('site.help.olark_chart.frontend') === true)
    @include('layouts.shared.olark')
@endif
<div id="wrapper">

    @section('main-nav')
        <header>
            @include('layouts.frontend.sections.navigation.main-nav', ['small' => false])
        </header>
    @show
    @include('_partials.no-javascript')
    <div class="container-fluid">
        @section('breadcrumbs')
            <div class="row  ">
                <div class="col-md-12 hidden-xs">
                    <div class="m-t-10">
                        {!! Breadcrumbs::renderIfExists() !!}
                    </div>
                </div>
            </div>
        @show

        @section('notification')

            @include('flash::message')

        @show
    </div>


    @section('slider')
        <div class="row">
            @include('layouts.frontend.sections.slider.main-slider', ['size' => 12])
        </div>
    @show


    <div id="ajax-image"></div>

    @section('content')

    @show

    @section('brands')

        @include('layouts.frontend.sections.footer.brands')

    @show
    @section('footer')

        @include('layouts.frontend.sections.footer.footer')

    @show
</div>

<!-- all javascript assets come here -->
@section('scripts')
    {!! HTML::script('js/frontend/libs.js') !!}
    {!! HTML::script('js/frontend/main.js') !!}
@show
<script>
    $('#flash-overlay-modal').modal();
</script>

</body>

</html>