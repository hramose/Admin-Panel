@extends('adminPanel::layouts.column1')

@section('links')
    <li><a href="{{ route('admin.permission.index') }}"><i class="glyphicon glyphicon-th-list"></i> Список Прав</a></li>
    <li><a href="{{ route('admin.permission.create') }}"><i class="glyphicon glyphicon-plus"></i> Создать Право</a></li>
@stop

@section('content')

    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">Редактировать Право "{{ $permission->name }}"</h3>
            	  </div>
            	  <div class="panel-body">
                      {!! Form::model($permission, ['method'=>'PATCH', 'route'=>['admin.permission.update','permission'=>$permission]]) !!}
                        @include('adminPanel::permission._form')
                      {!! Form::close() !!}
            	  </div>
            </div>
        </div>

    </div>

@stop