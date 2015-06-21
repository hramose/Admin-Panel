@extends('adminPanel::layouts.master')

@section('content')

    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            @yield('links')
        </ul>
    </div>
    <div class="col-md-9">
        @yield('content')
    </div>

@overwrite