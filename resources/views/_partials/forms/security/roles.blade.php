<div class="form-group">
    {!! Form::label('name', "Role Name:", []) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a role name']) !!}
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
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'describe the role']) !!}
    @if($errors->has('description'))
        <span class="wow flash error-msg">{{ $errors->first('description') }}</span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('permissions', "Permissions:", []) !!}
    {!! Form::select('permissions[]', App\Models\Permission::lists('name', 'id')->all(), null, [ "class" => "form-control permissions-assignment" , "multiple" => "multiple" ]) !!}
    @if($errors->has('permissions'))
        <span class="wow flash error-msg">{{ $errors->first('permissions') }}</span>
    @endif
</div>
