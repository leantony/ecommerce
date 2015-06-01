@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>
        {{ Request::has('q') ? "View products" : "Search results for " . Request::get('q') }}
    </title>
@stop
@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row single-product outer-bottom-sm  ">
                <div class="col-md-2 sidebar">
                    @include('_partials.data.general-product-data.sidebar-data-filters')
                </div>
                <!-- /.sidebar -->

                <div class="col-md-10">
                    @if($products->isEmpty())
                        <div class="row">
                            <div class="alert alert-info alert-dismissable" id="dismiss">
                                <button type="button" class="close" data-dismiss="alert" data-toggle="tooltip"
                                        data-placement="top" title="dismiss message">&times;
                                </button>
                                <h5 class="text text-center">Sorry. We found no products matching your search query of
                                    '{{ Request::get('q') }}'.</h5>
                            </div>
                            <h5>View more products below</h5>
                            <section class="section  ">
                                <h2 class="section-title">New products</h2>
                                @include('_partials.data.home-page.new-products', ['ratingClass' => 'text-md', 'priceClass' => 'text-md'])
                            </section>
                            <section class="section   m-t-30">
                                <h2 class="section-title">Top Rated products</h2>
                                @include('_partials.data.home-page.top-rated-products', ['ratingClass' => 'text-md', 'priceClass' => 'text-md'])
                            </section>
                        </div>
                    @else
                        @if(Request::has('q'))
                            <div class="row">
                                <div class="alert alert-info alert-dismissable" id="dismiss">
                                    <button type="button" class="close" data-dismiss="alert" data-toggle="tooltip"
                                            data-placement="top" title="dismiss message">&times;
                                    </button>
                                    <h4 class="text text-center">You searched for '{{ Request::get('q') }}'. We
                                        found {{ $products->count() }} results.</h4>
                                </div>
                            </div>
                        @endif
                        <div class="clearfix filters-container m-t-10">
                            <div class="row">
                                @include('_partials.data.general-product-data.filters')
                                @include('_partials.data.general-product-data.paginator-links', ['products' => $products])

                            </div>

                        </div>
                        <div class="search-result-container">
                            <div id="myTabContent" class="tab-content">
                                @include('_partials.data.general-product-data.grid-view', ['products' => $products])
                                @include('_partials.data.general-product-data.list-view', ['products' => $products])
                            </div>

                            <div class="clearfix filters-container">
                                @include('_partials.data.general-product-data.paginator-links')
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
@stop