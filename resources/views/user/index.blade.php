@extends('adminPanel::layouts.column1')

@section('links')
    <li><a href="{{ route('admin.user.index') }}"><i class="glyphicon glyphicon-th-list"></i> Список пользователей</a></li>
    <li><a href="{{ route('admin.register') }}"><i class="glyphicon glyphicon glyphicon-plus"></i> Создать пользователя</a></li>
@stop

@section('content')

    {!! $grid !!}

@stop