@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Orders</title>
@stop

@section('content')

    <h3>Product Orders made by Guest users</h3>
    <p>This section displays all orders made by 'guest' users, ie those who made an order without creating an account. To view more details about an order, click on the 'details' button</p>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <div class="pull-right">
                <a href="{{ route('backend.orders.index') }}">
                    <button class="btn btn-success">
                        <i class="fa fa-user"></i>&nbsp;View User orders
                    </button>
                </a>
            </div>
        </div>
        <div class="col-md-12 m-t-20">
            <h5>Displaying All Orders made by Guests</h5>
            <hr/>
            <!-- /input-group -->
            <table id="order-guests-table" class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Products purchased</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Delivery status</th>
                    <th>more</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
@stop