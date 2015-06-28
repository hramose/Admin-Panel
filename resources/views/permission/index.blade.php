@extends('adminPanel::layouts.column1')


@section('links')
    <li><a href="{{ route('admin.permission.index') }}"><i class="glyphicon glyphicon-th-list"></i> Права</a></li>
    <li><a href="{{ route('admin.permission.create') }}"><i class="glyphicon glyphicon-plus"></i> Добавление прав</a></li>
@stop

@section('content')

    <h1>Права</h1>

    {!! $grid !!}

@stop