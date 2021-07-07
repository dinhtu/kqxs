<?php
$namespace = 'App\Modules\Api\Controllers';

Route::group([
    'module' => 'Api',
    'prefix'=>'api/v1',
    'namespace' => $namespace
], function () {
    Route::resource('register', 'RegisterController');
    Route::post('login', 'LoginController@login');
    // Route::resource('users', 'UsersController');
    // Route::get('users', 'Users@index')->name('order.store');
});
Route::group([
    'module' => 'Api',
    'prefix'=>'api/v1',
    'namespace' => $namespace,
    'middleware' => ['auth.jwt']
], function () {
    Route::resource('users', 'UsersController');
    Route::post('/logout', 'UsersController@logout');
    Route::get('/get-current-user', 'UsersController@getCurrentUser');
});
