<div class="form-group">
    {!! Form::label('name', "County Name:", []) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a county name', 'required']) !!}
    @if($errors->has('name'))
        <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('alias', "County Alias (just a short name):", []) !!}
    {!! Form::text('alias', null, ['class' => 'form-control', 'placeholder' => 'eg, NRB for nairobi']) !!}
    @if($errors->has('alias'))
        <span class="wow flash error-msg">{{ $errors->first('alias') }}</span>
    @endif
</div>