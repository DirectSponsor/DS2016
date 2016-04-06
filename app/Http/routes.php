<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function()
{
    return View::make('auth.login');
});
//
// Project routes
//
Route::resource('projects', 'ProjectsController');
Route::get('/projects',array('as'=>'projects','uses'=>'ProjectsController@index'));
Route::get('/projects/create',array('as'=>'project.create','uses'=>'ProjectsController@create'));
Route::put('/projects/store',array('as'=>'project.store','uses'=>'ProjectsController@store'));
Route::get('/projects/edit/{pid}',array('as'=>'project.edit','uses'=>'ProjectsController@edit'));
Route::post('/projects/update/{pid}',array('as'=>'project.update','uses'=>'ProjectsController@update'));
Route::get('/projects/{id}/support',array('as'=>'project.support','uses'=>'ProjectsController@supportShow'));
Route::post('/projects/{id}/support/confirm',array('as'=>'project.supportconfirm','uses'=>'ProjectsController@supportConfirm'));
//
Route::put('/projects/{pid}/withdraw',array('as'=>'projects.withdraw','uses'=>'ProjectsController@withdraw'));
Route::put('/projects/{pid}/close',array('as'=>'projects.close','uses'=>'ProjectsController@close'));
Route::put('/projects/{pid}/open',array('as'=>'projects.open','uses'=>'ProjectsController@open'));
//
// Member routes
//
Route::get('/members/{pid}/recipients',array('as'=>'recipients.list','uses'=>'MembersController@listMembers'));
Route::get('/members/{pid}/sponsors',array('as'=>'sponsors.list','uses'=>'MembersController@listMembers'));

Route::delete('/sponsors/{id}/activate', array('as'=>'sponsors.activate','uses'=>'MembersController@activate'));
Route::delete('/sponsors/{id}/{pid}/suspend', array('as'=>'sponsors.suspend','uses'=>'MembersController@suspend'));

Route::resource('coordinators', 'CoordinatorsController');
Route::get('/coordinators/{id}/projects',array('as'=>'projects.perCoordinator','uses'=>'ProjectsController@perCoordinator'));

// Transaction routes
//
Route::get('/transactions/pending/{projectid}/{memberId?}', array('as' => 'pendingreceipts', 'uses' => 'TransactionsController@pendingReceipts'));
Route::post('/transactions/{transid}/confirm', array('as' => 'receipt.confirm', 'uses' => 'TransactionsController@confirmReceipt'));
Route::post('/transactions/{transid}/late', array('as' => 'receipt.late', 'uses' => 'TransactionsController@confirmLate'));
Route::get('/transactions/add/receipt',array('as'=>'payments.add','uses'=>'TransactionsController@add'));
Route::post('/transactions/save/{pid}/receipt',array('as'=>'payments.save','uses'=>'TransactionsController@save'));
Route::get('/transactions/{projectid}/spends',array('as'=>'project.spends','uses'=>'TransactionsController@spends'));

// Invitation routes
//
Route::get('/invitations',array('as'=>'invitations.index','uses'=>'InvitationsController@index'));
Route::put('/invitation/{pid}/store',array('as'=>'invitation.store','uses'=>'InvitationsController@store'));
Route::get('/invitations/{invitationId}/resend',array('as'=>'invitation.resend','uses'=>'InvitationsController@resend'));

// Authentication routes...
//
Route::get('/auth/login', array('as' => 'login', 'Auth\AuthController@getLogin'));
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Account / Registration routes...
//
Route::get('/register/sponsor', array('as' => 'register.sponsor', 'uses' => 'Auth\AuthController@getRegister'));
Route::get('/register/member/{encyptedstring}', array('as' => 'register.user', 'uses' => 'Auth\AuthController@getRegister'));
Route::post('/register/sponsor', 'Auth\AuthController@postRegister');
Route::post('/register/member', 'Auth\AuthController@postRegister');
Route::get('/register/{hash}/confirm/sponsor',array('as'=>'sponsor.confirm','uses'=>'UsersController@confirm'));
Route::get('/register/{hash}/confirm/recipient',array('as'=>'recipient.confirm','uses'=>'UsersController@confirm'));
Route::get('/register/{hash}/confirm/coordinator',array('as'=>'coordinator.confirm','uses'=>'UsersController@confirm'));
//
Route::get('/panel',array('as'=>'panel','uses'=>'UsersController@panel'));
Route::get('/resend', array('as'=>'users.resendConfEmailForm', 'uses' => 'UsersController@resendConfEmailForm'));
//
// User routes
//
Route::get('/user/{id}/edit',array('as'=>'user.edit', 'uses' => 'UsersController@edit'));
Route::put('/user/{id}/updatedetails',array('as'=>'user.updateDetails', 'uses' => 'UsersController@updateDetails'));
Route::put('/user/{id}/changePassword',array('as'=>'user.updatePass', 'uses' => 'UsersController@updatePass'));
//
// Password reset link request routes...
//
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
//
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
