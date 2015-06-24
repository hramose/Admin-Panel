@extends('adminPanel::layouts.column1')


@section('links')
    <li><a href="{{ route('admin.role.index') }}"><i class="glyphicon glyphicon-th-list"></i> Список ролей</a></li>
    <li><a href="{{ route('admin.role.create') }}"><i class="glyphicon glyphicon-plus"></i> Создать роль</a></li>
@stop

@section('content')

    {!! $grid !!}

@stop