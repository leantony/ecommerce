@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>Viewing products in {{ $subcategory->name }}</title>
@stop

@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row single-product outer-bottom-sm ">
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
                                <p class="text text-center">Sorry. There are
                                    currently no products belonging to '{{ beautify($subcategory->name) }}'.</p>
                            </div>
                            <p>View more products below</p>
                            <section class="section  ">
                                <h2 class="section-title">New products</h2>
                                @include('_partials.data.home-page.new-products')
                            </section>
                            <section class="section   m-t-30">
                                <h2 class="section-title">Top Rated products</h2>
                                @include('_partials.data.home-page.top-rated-products')
                            </section>
                        </div>
                    @else
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