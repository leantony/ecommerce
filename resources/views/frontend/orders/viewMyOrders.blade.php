@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>PC World&nbsp;&middot;&nbsp;Your orders</title>
@stop

@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')

    <div class="container" style="margin-bottom: 84px">
        <div class="row outer-top-bd">
            <h1>{{ $auth_user->present()->fullName . "'s orders" }}</h1>
            <hr/>
            <div class="col-md-8">
                <p>Click on an order to display more details about it</p>
                <table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"
                       data-sort-name="order_id"
                       data-sort-order="asc"
                       data-show-toggle="true"
                       data-show-columns="true">
                    <thead>
                    <tr>
                        <th data-field="order_id" data-sortable="true">Order ID</th>
                        <th data-field="order_date" data-sortable="true">Order date</th>
                        <th data-field="order_delivery_status" data-sortable="true">Delivery status</th>
                        <th data-field="order_products" data-sortable="true">products ordered</th>
                        <th data-field="edit">view details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)

                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at }}</td>
                            @if($order->delivered)
                                <td><span class="label label-success">Delivered!!</span></td>
                            @else
                                <td><span class="label label-info">Not yet delivered</span></td>
                            @endif
                            <td>{{ $order->products->count() }}</td>

                            <td>
                                <p data-placement="top" data-toggle="tooltip" title="Edit">
                                    <a href="{{ route('viewOrder', ['order' => $order->id]) }}">
                                        <button class="btn btn-primary btn-xs">
                                            <span class="fa fa-eye"></span>&nbsp;View
                                        </button>
                                    </a>

                                </p>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@stop

@section('brands')

@stop