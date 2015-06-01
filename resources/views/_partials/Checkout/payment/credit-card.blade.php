<form accept-charset="UTF-8" action="{{ $route }}" class="require-validation" id="payment-form" method="post">
    {!! Form::token() !!}
    <div class='form-row'>
        <div class='col-xs-12 form-group required'>
            <label class='control-label' for="cardName">Name on Card</label>
            <input id="cardName" name="cardName" class='form-control' size='4' type='text'
                   required>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 form-group card'>
            <label class='control-label' for="cardNo">Card Number</label>
            <input id="cardNo" name="cardNo" autocomplete='off' class='form-control'
                   size='20' type='text' required>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-4 form-group cvc required'>
            <label for="cvc" class='control-label'>CVC</label>
            <input id="cvc" name="cvc" autocomplete='off' class='form-control'
                   placeholder='ex. 311' size='4' type='text' required>
        </div>
        <div class='col-xs-4 form-group expiration'>
            <label class='control-label'>Expiration</label>
            {!! Form::selectMonth('month', null, ['class' => 'form-control required']) !!}
        </div>
        <div class='col-xs-4 form-group expiration'>
            <label class='control-label'>Year</label>
            {!! Form::selectYear('year', date('Y'), 2025, null, ['class' => 'form-control required']) !!}
        </div>
    </div>
    @if(isset($hideSubmitButton))

    @else
        <div class="form-group col-md-12 m-t-20">
            <button class="btn btn-primary pull-right btn-block" type="submit">
                proceed to order page&nbsp;<i class="fa fa-arrow-right"></i>
            </button>
        </div>
    @endif
</form>
@if(isset($hideSubmitButton))
    <div class="form-group col-md-12 m-t-20">
        <a href="{{ $secondRoute }}">
            <button class="btn btn-primary pull-right btn-block">
                proceed to order page&nbsp;<i class="fa fa-arrow-right"></i>
            </button>
        </a>
    </div>
@endif