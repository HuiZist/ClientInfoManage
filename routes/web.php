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
    return view('welcome');
});

Auth::routes();



Route::post('/user/passwordReset', 'UserController@passwordReset')->name('user.passwordReset');
Route::post('/user/passwordResetting', 'UserController@passwordResetting')->name('user.passwordResetting');

Route::group(['middleware'=>'auth'],function(){
	Route::post('/client/upload', 'ClientController@upload')->name('client.upload');
	Route::get('/client', 'ClientController@client')->name('client.client');
	Route::get('/client/truncate', 'ClientController@truncate')->name('client.truncate');
	Route::get('/client/search', 'ClientController@search')->name('client.search');

	Route::post('/client/order', 'ClientController@order');

	Route::get('/contact', 'ContractController@show')->name('contract.show');
	Route::post('/contact/upload', 'ContractController@upload')->name('contract.upload');
	Route::get('/contact/create', 'ContractController@create')->name('contract.create');
	Route::post('/contact/add', 'ContractController@add')->name('contract.add');
	Route::get('/contact/delete/{contactId}', 'ContractController@delete')->name('contract.delete');
	Route::get('/contact/editor/{contactId}', 'ContractController@editor')->name('contract.editor');
	Route::post('/contact/update', 'ContractController@update')->name('contract.update');
	Route::get('/contact/search', 'ContractController@search')->name('contract.search');

	Route::post('/contact/order', 'ContractController@order');
	Route::post('/contact/searchAct', 'ContractController@searchAct');
	Route::post('/remind', 'RemindController@search');

	Route::get('/procedure', 'ProcedureController@show')->name('procedure.show');
	Route::post('/procedure/upload', 'ProcedureController@upload')->name('procedure.upload');
	Route::post('/procedure/create', 'ProcedureController@create')->name('procedure.create');
	Route::get('/procedure/destory/{proceId}', 'ProcedureController@destory');
	Route::get('/procedure/editor/{proceId}', 'ProcedureController@editorView');
	Route::post('/procedure/editor/upload', 'ProcedureController@editor')->name('procedure.editor');
	Route::get('/procedure/search', 'ProcedureController@search')->name('procedure.search');

	Route::get('/procedure/supple/{proceId}', 'SuppleController@createView');
	Route::post('/procedure/supple/create', 'SuppleController@create')->name('supple.create');
	Route::get('/procedure/supple/destroy/{supId}', 'SuppleController@destroy');

	Route::get('/topic', 'TopicController@show')->name('topic.show');
	Route::post('/topic/upload', 'TopicController@upload')->name('topic.upload');
	Route::post('/topic/create', 'TopicController@create')->name('topic.create');
	Route::get('/topic/destory/{topicId}', 'TopicController@destory');
	Route::get('/topic/editor/{topicId}', 'TopicController@editorView');
	Route::post('/topic/editor/upload', 'topicController@editor')->name('topic.editor');
	Route::get('/topic/search', 'TopicController@search')->name('topic.search');

	Route::get('/statistics', 'StatisticsController@show')->name('statistics.show');
	Route::get('/statistics/link/{userId}/{stat}','StatisticsController@link')->name('contract.link');

	Route::get('/manage', 'UserController@memberShow')->name('manage.memberShow')->middleware('can:isSupAdmin');
	Route::get('/manage/admin/{userId}','UserController@adminSet')->name('manage.adminSet')->middleware('can:isSupAdmin');
	Route::get('/manage/member/{userId}','UserController@memberSet')->name('manage.memberSet')->middleware('can:isSupAdmin');
	Route::get('/manage/delete/{userId}','UserController@memberDelete')->name('manage.memberDelete')->middleware('can:isSupAdmin');

	Route::get('/contactType', 'ContactBTypeController@show')->name('contactType.show')->middleware('can:isAdmin');
	Route::post('/contactBType/add', 'ContactBTypeController@add')->name('contactBType.add')->middleware('can:isAdmin');

	Route::post('/contactSType/add', 'ContactSTypeController@add')->name('contactSType.add')->middleware('can:isAdmin');
	Route::get('/contactBType/delete/{btypeId}', 'ContactBTypeController@delete')->middleware('can:isAdmin');
	Route::get('/contactSType/delete/{stypeId}', 'ContactSTypeController@delete')->middleware('can:isAdmin');

	Route::get('/contactBType/editor/{btypeId}', 'ContactBTypeController@editor')->middleware('can:isAdmin');
	Route::post('/contactBType/update', 'ContactBTypeController@update')->name('contactBType.update')->middleware('can:isAdmin');

	Route::get('/contactSType/editor/{stypeId}', 'ContactSTypeController@editor')->middleware('can:isAdmin');
	Route::post('/contactSType/update', 'ContactSTypeController@update')->name('contactSType.update')->middleware('can:isAdmin');

	Route::get('/statdef', 'StatdefController@show')->name('statdef.show')->middleware('can:isAdmin');
	Route::post('/statdef/create', 'StatdefController@create')->name('statdef.create')->middleware('can:isAdmin');
	Route::post('/statdef/titleUpdate', 'StatdefController@titleUpdate')->name('statdef.titleUpdate')->middleware('can:isAdmin');

	Route::get('/title/show','UserController@title')->name('title.show')->middleware('can:isAdmin');
	Route::post('/title/cliUpdate','UserController@cliUpdate')->name('title.cliUpdate')->middleware('can:isAdmin');
	Route::post('/title/conUpdate','UserController@conUpdate')->name('title.conUpdate')->middleware('can:isAdmin');

	Route::get('/client/link/{cliId}','ContractController@link')->name('contract.link');
	Route::get('/contact/link/tc','ContractController@linkTc')->name('contract.linkTc');



});

