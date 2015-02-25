<?php

Route::get('/', ['as' => 'admin.home', function() {
    return view('adminPanel::hello');
}]);