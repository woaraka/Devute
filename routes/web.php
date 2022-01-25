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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'Admin\LoginController@showloginForm')->name('admin.login');
Route::post('/admin', 'Admin\LoginController@login');
Route::post('/admin/password-email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('/admin/password-reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('/admin/password-reset', 'Admin\ResetPasswordController@reset');
Route::get('/admin/password-reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');


Route::get('admin/home', 'AdminController@index');
Route::post('admin/email/update/{id}', 'AdminController@update_email')->name('admin.email.update');

//Page
Route::get('/page', 'PageController@index')->name('page');
Route::post('/page/insert', 'PageController@create')->name('page.insert');
Route::put('/page/update/{id}', 'PageController@update')->name('page.update');
//end Page


//page assign
Route::get('/page-assign-employee', 'PageUserController@index')->name('PageAssignEmp');
Route::post('/page-assign-employee/insert', 'PageUserController@store')->name('PageAssignEmp.insert');
Route::post('/page-assign-employee/update', 'PageUserController@update')->name('PageAssignEmp.update');
//end page assign


//page assign demo
Route::get('/sales', 'SalesController@index')->name('sales');
Route::get('/purchase', 'PurchaseController@index')->name('purchase');
