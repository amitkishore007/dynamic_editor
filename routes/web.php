<?php

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
    return view('layouts.master');
});

Route::group(['prefix'=>'v1'],function(){

    Route::group(['prefix'=>'workflow'],function(){
        Route::get('/',['as'=>'workflow','uses'=>'AdminController@showWorkflow']);
        
        Route::get('/{process}', ['as'=>'workflow_single','uses'=>'AdminController@workflow']);
        Route::get('/task/{id}','AdminController@showTask');
    });

    Route::post('/otp_request','AdminController@otp_request');
    Route::post('/register','AdminController@register');
    Route::post('/login','AdminController@login');
    
    Route::group(['prefix'=>'application'],function(){
        Route::post('/','AdminController@createApplication');
        Route::post('/basic-info','AdminController@basicInfo');
        Route::post('/loan-info','AdminController@loanInfo');
    });
    
    Route::post('/taskform','AdminController@showform');
    Route::post('/taskform/create-field','AdminController@createField');
    Route::get('/taskform/create',['as'=>'create_form','uses'=>'AdminController@createForm']);
    Route::post('/taskform/getform','AdminController@getform');
    Route::post('/taskform/getfields','AdminController@getfields');


});
