<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
});

Route::get('update/update.asp', 'Update\UpdateController@index');
Route::group(['prefix' => 'file_types', 'namespace' => 'FileTypes', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'FileTypesController@index');
  Route::get('/create', 'FileTypesController@create');
  Route::post('/store', 'FileTypesController@store');
  Route::get('/edit/{id}', 'FileTypesController@edit');
  Route::post('/update/{id}', 'FileTypesController@update');
});

Route::group(['prefix' => 'upgrade_file', 'namespace' => 'UpgradeFile', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'UpgradeFileController@index');
  Route::get('/create', 'UpgradeFileController@create');
  Route::post('/store', 'UpgradeFileController@store');
  Route::get('/edit/{id}', 'UpgradeFileController@edit');
  Route::post('/update/{id}', 'UpgradeFileController@update');
  Route::get('/download/{id}', 'UpgradeFileController@download');
  Route::get('/search', 'UpgradeFileController@search');
  Route::post('/search', 'UpgradeFileController@search');
});

Route::group(['prefix' => 'device_info', 'namespace' => 'DeviceInfo', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'DeviceInfoController@index');
  Route::post('/', 'DeviceInfoController@index');
});


Route::group(['prefix' => 'company_device', 'namespace' => 'CompanyDevice', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'CompanyDeviceController@index');

});

Route::group(['prefix' => 'company_update', 'namespace' => 'CompanyUpdate', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'CompanyUpdateController@index');
  Route::get('/jsondata', 'CompanyUpdateController@query');

});

Route::group(['prefix' => 'update_map', 'namespace' => 'UpdateMap', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'UpdateMapController@index');
  Route::post('/jsondata', 'UpdateMapController@query');
});

Route::group(['prefix' => 'update_trend', 'namespace' => 'UpdateTrend', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'UpdateTrendController@index');
});

Route::group(['prefix' => 'version_distribute', 'namespace' => 'VersionDistribute', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'VersionDistributeController@index');
});

Route::group(['prefix' => 'update_log', 'namespace' => 'UpdateLog', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'UpdateLogController@index');
  Route::post('/', 'UpdateLogController@index');
});

Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => ['web', 'auth']], function()  
{
  Route::get('/', 'UserController@index');
  Route::get('/create', 'UserController@create');
  Route::post('/store', 'UserController@store');
});
