<div class="form-group">
    {!! Form::label('name', "Permission Name:", []) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a permission name']) !!}
    @if($errors->has('name'))
        <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('display_name', "Display Name:", []) !!}
    {!! Form::text('display_name', null, ['class' => 'form-control', 'placeholder' => 'a short descriptive name']) !!}
    @if($errors->has('display_name'))
        <span class="wow flash error-msg">{{ $errors->first('display_name') }}</span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('description', "Description:", []) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'describe the permission']) !!}
    @if($errors->has('description'))
        <span class="wow flash error-msg">{{ $errors->first('description') }}</span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('roles', "Select the roles you want this permission to apply:", []) !!}
    {!! Form::select('roles[]', App\Models\Role::lists('name', 'id')->all(), null, [ "class" => "form-control roles-assignment" , "multiple" => "multiple" ]) !!}
    @if($errors->has('roles'))
        <span class="wow flash error-msg">{{ $errors->first('roles') }}</span>
    @endif
</div>
