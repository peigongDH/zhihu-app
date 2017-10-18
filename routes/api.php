<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->get('/topic', 'TopicController@index');

Route::middleware('api')->post('/question/followers', 'QuestionFollowController@follower');
Route::middleware('auth:api')->post('/question/follow', 'QuestionFollowController@followThisQuestion');


Route::middleware('api')->post('/user/followers', 'FollowerController@index');
Route::middleware('auth:api')->post('/user/follow', 'FollowerController@follow');

Route::middleware('api')->post('/answer/vote/users', 'VoteController@users');
Route::middleware('auth:api')->post('/answer/vote', 'VoteController@vote');

Route::middleware('auth:api')->post('/message/create', 'MessageController@create');

Route::middleware('api')->get('/answer/{id}/comments', 'CommentController@answer');
Route::middleware('api')->get('/question/{id}/comments', 'CommentController@question');

Route::middleware('auth:api')->post('/comment', 'CommentController@store');

Route::middleware('api')->get('/item/question', 'Api\QuestionController@index');
Route::middleware('api')->get('/item/answer/{id}', 'Api\AnswerController@index');

Route::middleware('auth:api')->get('/item/action/{id}', 'Api\ActionController@index');
Route::middleware('auth:api')->get('/item/timeline', 'Api\TimelineController@index');
Route::middleware('auth:api')->get('/item/message', 'Api\MessageController@index');
Route::middleware('auth:api')->get('/item/notification', 'Api\NotificationController@index');

// use for skynet-todpole
Route::middleware('api')->post('/auth', 'Api\AuthController@auth');

// use for zhihu-app-timeline to bind uid
Route::middleware('auth:api')->post('/bind', 'Api\BindController@bind');