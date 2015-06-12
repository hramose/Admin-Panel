@extends('adminPanel::layouts.master')

@section('content')

    <div class="container">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="{{ route('admin.user.index') }}">Список пользователей</a></li>
                <li><a href="{{ route('admin.register') }}">Создать пользователя</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            @yield('content')
        </div>
    </div>

@overwrite