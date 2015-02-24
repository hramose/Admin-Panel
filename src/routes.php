<?php


Route::get('/', ['as' => 'admin.home', function() {
    return view('adminPanel::hello');
}]);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);