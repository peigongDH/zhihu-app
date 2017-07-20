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

Route::get('/', 'QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email/verify/{token}', ['as' => 'email.verify', 'uses' => 'EmailController@verify']);

Route::resource('question', 'QuestionController', ['names' =>
    [
        'create' => 'questions.create',
        'show' => 'questions.show',
    ]
]);

Route::post('question/{question}/answer', 'AnswerController@store');

Route::get('question/{question}/follow', 'QuestionFollowController@follow');

Route::get('notification', 'NotificationController@index');
Route::get('notification/{notification}', 'NotificationController@show');

Route::get('avatar', 'UserController@avatar');
Route::post('avatar', 'UserController@upload');

Route::get('password', 'PasswordController@password');
Route::post('password', 'PasswordController@update');

Route::get('setting', 'SettingController@index');
Route::post('setting', 'SettingController@store');

Route::get('index', 'InboxController@index');
Route::get('index/{dialogId}', 'InboxController@show');
Route::post('index/{dialogId}/store', 'InboxController@store');
