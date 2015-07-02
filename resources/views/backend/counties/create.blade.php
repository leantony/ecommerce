@extends('layouts.backend.master')

@section('header')
    @parent
    <title>Add County</title>
@stop

@section('content')

    <div class="row admin-form">
        <div class="col-md-12">
            <p>Add counties that the products bought can be shipped to</p>
            <hr/>
            <div class="msgDisplay m-t-10"></div>
        </div>

        {!! Form::open(['url' => route('backend.counties.store'), 'id' => 'countiesAddForm', 'data-remote']) !!}
        <div class="col-md-6 category">

            @include('_partials.forms.counties.counties_form')
            <hr/>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-ok-sign"></span> Add county
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@stop