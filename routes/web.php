<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['uses' => 'IndexController@show', 'middleware' => 'accesstoken', 'as' => 'home']);

Route::get('/deal', ['uses' => 'DealController@show', 'middleware' => 'accesstoken', 'as' => 'newdeal']);
Route::post('/deal', ['uses' => 'DealController@save', 'middleware' => 'accesstoken', 'as' => 'savedeal']);
Route::get('/deal/{id}/tasks', ['uses' => 'DealController@getTasks', 'middleware' => 'accesstoken', 'as' => 'tasks']);
Route::get('/deal/{id}/add/task', ['uses' => 'DealController@addTask', 'middleware' => 'accesstoken', 'as' => 'addtask']);
Route::post('/deal/add/task', ['uses' => 'DealController@saveTask', 'middleware' => 'accesstoken', 'as' => 'savetask']);

Route::match(['get', 'post'], '/login', ['uses' => 'AuthorizeController@getToken', 'middleware' => 'accesstoken', 'as' => 'token']);

//Route::get('/test/deals', ['uses' => 'TestController@getDeals', 'middleware' => 'timeisover', 'as' => 'testDeals']);
//Route::get('/test/insert/deal', ['uses' => 'TestController@insertDeal', 'middleware' => 'timeisover', 'as' => 'testInsertDeal']);
//Route::get('/test/insert/lead', ['uses' => 'TestController@insertLead', 'middleware' => 'timeisover', 'as' => 'testInsertLead']);
//Route::get('/test/users', ['uses' => 'TestController@getUsers', 'middleware' => 'timeisover', 'as' => 'testUsers']);
//Route::get('/test/modules', ['uses' => 'TestController@getModules', 'middleware' => 'timeisover', 'as' => 'testModules']);
//Route::get('/test/fields', ['uses' => 'TestController@getFieldsDeals', 'middleware' => 'timeisover', 'as' => 'testFieldsDeals']);
//Route::get('/test/tasks', ['uses' => 'TestController@getTasks', 'middleware' => 'timeisover', 'as' => 'testTasks']);
//Route::get('/test/deal/add/task', ['uses' => 'TestController@saveTask', 'middleware' => 'timeisover', 'as' => 'testSaveTask']);


