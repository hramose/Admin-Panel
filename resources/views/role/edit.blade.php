@extends('adminPanel::layouts.column1')

@section('links')
    <li><a href="{{ route('admin.role.index') }}"><i class="glyphicon glyphicon-th-list"></i> Список ролей</a></li>
    <li><a href="{{ route('admin.role.create') }}"><i class="glyphicon glyphicon-plus"></i> Создать роль</a></li>
@stop

@section('content')

    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">Редактор роли: "{{ $role->name }}"</h3>
            	  </div>
            	  <div class="panel-body">
                      {!! Form::model($role, ['method'=>'PATCH', 'route'=>['admin.role.update','role'=>$role]]) !!}
                        @include('adminPanel::role._form')
                      {!! Form::close() !!}
            	  </div>
            </div>
        </div>

    </div>

@stop