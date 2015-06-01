@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Search</title>
@stop

@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>Possible solutions</p>
                    <ol class="list-group">
                        <li>
                            Try reducing the length of your search query, for better results
                        </li>
                        <li>
                            Try searching for a product by its specs, color, storage, etc
                            eg. to find a laptop with an i3 cpu, your can try searching for 'i3"
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row m-t-20">
                <div class="col-md-12">
                    <h3>View more products</h3>
                    <section class="section  m-b-20">
                        <h2 class="section-title">Featured Laptops</h2>
                        @include('_partials.data.home-page.featured-products', ['data' => $featuredLaptops])
                    </section>
                </div>

            </div>

        </div>
    </div>
@stop