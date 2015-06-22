@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Orders</title>
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Totals</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Number of orders made today</th>
                        <th>Sales total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="{{ $countToday == 0 ? "danger" : "success" }}">
                        <td>{{ $countToday }}</td>
                        <td>{{ $salesToday }}</td>
                    </tr>
                    </tbody>
                </table>
                <hr/>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Total Number of orders made</th>
                        <th>Grand Sales total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="{{ $countOverall < 1 ? "danger" : "success" }}">
                        <td>{{ $countOverall }}</td>
                        <td>{{ $totalSales }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
