@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Edit county</title>
@stop

@section('content')
    <div class="row admin-form">
        <h2>You are editing county [ <b>{{ $county->name }}</b> ]</h2>

        <div class="col-md-12">
            <a href="{{ url(URL::previous()) }}">
                <button class="btn btn-primary"><i class="fa fa-arrow-left"></i>&nbsp;Back</button>
            </a>
        </div>
        <br/>
        <hr/>
        <div class="msgDisplay m-t-10"></div>
        {!! Form::model($county, ['url' => action('Backend\CountiesController@update', ['id' => $county->id]), 'method' => 'PATCH', 'data-remote']) !!}
        <div class="col-md-6 category">
            @include('_partials.forms.counties.counties_form')
            <hr/>
            <div class="pull-left">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Finish Edit
                </button>
            </div>
            <div class="pull-right">
                <a href="#" data-toggle="modal" data-target="#deleteCounty">
                    <button class="btn btn-danger" data-title="Delete">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @include('_partials.modals.actionModals.delete', ['elementID' => 'deleteCounty', 'route' => route('backend.counties.destroy', ['id' => $county->id])])
@stop