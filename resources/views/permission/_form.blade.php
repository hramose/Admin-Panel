<div class="form-group @if($errors->has('name')) has-error @endif">
    {!! Form::label('name') !!}
    {!! Form::text('name', null, ['class'=>'form-control']) !!}
    {!! $errors->first('name','<p class="help-block">:message</p>') !!}
</div>

<div class="form-group @if($errors->has('display_name')) has-error @endif">
    {!! Form::label('display_name') !!}
    {!! Form::text('display_name', null, ['class'=>'form-control']) !!}
    {!! $errors->first('display_name','<p class="help-block">:message</p>') !!}
</div>

<div class="form-group @if($errors->has('description')) has-error @endif">
    {!! Form::label('description') !!}
    {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
    {!! $errors->first('description','<p class="help-block">:message</p>') !!}
</div>

<div class="form-group @if($errors->has('roles')) has-error @endif">
    {!! Form::label('roles') !!}
    {!! Form::select('roles[]', $roles, isset($role_list) ? $role_list : null, ['class'=>'form-control', 'multiple']) !!}
    {!! $errors->first('roles','<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    {!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
</div>