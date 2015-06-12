@extends('adminPanel::layouts.column1')

@section('content')

    <h1>Обновить пользователя - {{ $user->name }}</h1>

    {!! Form::model($user, ['route' => ['admin.user.update', $user->id], 'method' => 'put']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Имя пользователя') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'New Password') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('roles') !!}
        {!! Form::select('roles[]', $rolesList, $user->roles->lists('id'), ['class' => 'form-control', 'multiple']) !!}
    </div>

    <button type="submit" class="btn btn-default btn-primary">Обновить</button>

    {!! Form::close() !!}

@stop