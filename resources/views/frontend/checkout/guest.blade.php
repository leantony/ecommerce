@extends('layouts.frontend.master')

@section('head')
    @parent
    <title>PC World&nbsp;&middot;&nbsp;Checkout</title>
@stop
@section('main-nav')
    @include('layouts.frontend.sections.navigation.main-nav', ['small' => true, 'altText' => 'Checkout'])
@stop

@section('slider')

@stop

@section('breadcrumb')

@show

@section('content')
    <div class="container checkout-wizard">

        <h2 class="text-center">Checkout</h2>
        <hr/>
        <div class="row bs-wizard" style="border-bottom:0;">
            @include('_partials.Checkout.firstStep.steps')
        </div>
        <div class="row " id="step-1">
            <div class="row">
                <form action="{{ route('checkout.step1.store', ['allow' => true]) }}" method="POST"
                      id="guestCheckoutForm">
                    {!! Form::token() !!}
                    <div class="col-md-5 col-md-offset-1 col-xs-12">
                        <h3>Checkout as a guest</h3>

                        <p class="bold">Please fill in this form. All fields are required</p>

                        <p>
                            <a href="{{ route('help.article.view', ['article' => 11, 'popup' => true]) }}" data-help
                               data-height="570" data-width="580">
                                Why do I need to supply this information?
                            </a>
                        </p>
                        <hr/>
                        <div class="msgDisplay m-t-10"></div>
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" maxlength="20"
                                   placeholder="Enter your first name"
                                   value="{{ isset($guest) ? $guest->first_name : old('first_name') }}" required>
                            @if($errors->has('first_name'))
                                <span class="wow flash error-msg">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="last_name">Second Name:</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" maxlength="20"
                                   placeholder="Enter your second name"
                                   value="{{ isset($guest) ? $guest->last_name : old('last_name') }}" required>
                            @if($errors->has('last_name'))
                                <span class="wow flash error-msg">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="county_id">Select your county:</label>

                            <p class="text text-help">currently, we only ship products to the counties listed
                                below</p>
                            {!! Form::select('county_id', str_replace('_', ' ', App\Models\County::lists('name', 'id')->all()), isset($guest) ? $guest->county->id : old('county_id'),  [ 'class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="town">Your Hometown: </label>
                            <span class="text text-help">Ensure that the town exists in the county you've selected</span>
                            <input type="text" id="town" name="town" class="form-control" maxlength="20"
                                   placeholder="e.g karen, muthaiga, langata..."
                                   value="{{ isset($guest) ? $guest->town : old('town') }}" required>
                            @if($errors->has('town'))
                                <span class="wow flash error-msg">{{ $errors->first('town') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="home_address">Your Home Address (where you live):</label>
                                <textarea id="home_address" name="home_address" rows="4"
                                          placeholder="home address, apartment,house number, etc" maxlength="100"
                                          required
                                          class="form-control">{{ isset($guest) ? $guest->home_address : old('home_address') }}</textarea>
                            @if($errors->has('home_address'))
                                <span class="wow flash error-msg">{{ $errors->first('home_address') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="phone">Your Phone number:</label>

                            <div class="input-group">
                                <span class="input-group-addon">+254</span>
                                <input type="text" id="phone" name="phone" placeholder="712345678" maxlength="9"
                                       required
                                       value="{{ isset($guest) ? $guest->phone : old('phone') }}" class="form-control">
                            </div>
                            @if($errors->has('phone'))
                                <span class="wow flash error-msg">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="form-group m-b-20">
                            <label for="email">Your Email Address:</label>
                            <span class="text text-help">We shall send your receipt to this address</span>
                            <input type="email" id="email" name="email" class="form-control"
                                   placeholder="Enter email address"
                                   value="{{ isset($guest) ? $guest->email : old('email') }}" required>
                            @if($errors->has('email'))
                                <span class="wow flash error-msg">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <hr/>
                        <button type="submit" class="btn btn-primary">
                            Continue to shipping page &nbsp;<i class="fa fa-arrow-right"></i>
                        </button>
                        <span class="alt-ajax-image"><img src="{{ alt_ajax_image() }}"> </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('brands')

@stop
@section('footer')
    @include('layouts.frontend.sections.footer.footer-basic')
@stop
