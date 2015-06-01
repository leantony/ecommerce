<div class="form-group">
    <label for="name">{{ $name }} name</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a category name']) !!}
    @if($errors->has('name'))
        <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
    @endif
</div>
<div class="form-group">
    <label for="alias">{{ $name }} Alias (just a short name)</label>
    {!! Form::text('alias', null, ['class' => 'form-control', 'placeholder' => 'Enter a category alias']) !!}
    @if($errors->has('alias'))
        <span class="wow flash error-msg">{{ $errors->first('alias') }}</span>
    @endif
</div>