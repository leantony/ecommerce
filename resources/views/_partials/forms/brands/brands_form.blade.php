<div class="form-group">
    {!! Form::label('name', "Brand Name:", []) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a brand name']) !!}
    @if($errors->has('name'))
        <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
    @endif
</div>
<div class="row">
    @if(empty($brand->logo))
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('logo', "Select a logo, that represents the manufacturer/brand. must be in PNG format (MAX SIZE, 1MB):", []) !!}
                {!! Form::file('logo', ['class' => 'form-control']) !!}
                @if($errors->has('logo'))
                    <span class="wow flash error-msg">{{ $errors->first('logo') }}</span>
                @endif
            </div>
        </div>
    @else

        <div class="col-md-12">
            <h3>Current logo</h3>
            <img src="{{ asset($brand->logo) }}" class="img-responsive img-thumbnail">
            <hr/>
            <div class="form-group">
                {!! Form::label('logo', "Select a logo, that represents the manufacturer/brand. must be in PNG format (MAX SIZE, 1MB):", []) !!}
                {!! Form::file('logo', ['class' => 'form-control']) !!}
                @if($errors->has('logo'))
                    <span class="wow flash error-msg">{{ $errors->first('logo') }}</span>
                @endif
            </div>
        </div>
    @endif
</div>
