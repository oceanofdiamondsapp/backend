<?php

/*
|--------------------------------------------------------------------------
| Temporary / Development Routes
|--------------------------------------------------------------------------
*/

// Static Pages
Route::get('/', 'DashboardController@index');
Route::get('settings', 'PageController@settings');

// Database Population
Route::get('/dummy/account', 'DummyController@account');
Route::get('/dummy/job', 'DummyController@job');
Route::get('/dummy/quote', 'DummyController@quote');
Route::get('/dummy/message', 'DummyController@message');

// Auth
Route::post('auth/password/reset', ['uses' => 'Auth\PasswordController@postForgotLink']);


/*
|--------------------------------------------------------------------------
| Basic Routes
|--------------------------------------------------------------------------
*/

// Accounts
Route::post('accounts/{id}/notes', ['as' => 'accounts.notes.store', 'uses' => 'AccountNoteController@store']);

// Quotes
Route::post('quotes/{id}/notes', ['as' => 'quotes.notes.store', 'uses' => 'QuoteNoteController@store']);

// Jobs
Route::post('jobs/{id}/quotes', ['as' => 'quotes.store', 'uses' => 'QuoteController@store']);
Route::post('jobs/{id}/messages', ['as' => 'jobs.messages.store', 'uses' => 'JobMessageController@store']);

// Orders
Route::post('orders/{id}/notes', ['as' => 'orders.notes.store', 'uses' => 'OrderNoteController@store']);

// PayPal Ordering
Route::get('paypal/success', 'PayPalController@success');
Route::get('paypal/cancel', 'PayPalController@cancel');
Route::get('paypal/thank-you', 'PayPalController@thanks');

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/

Route::resource('jobs', 'JobController', ['only' => ['index', 'show']]);
Route::resource('quotes', 'QuoteController', ['only' => ['index', 'show']]);
Route::resource('accounts', 'AccountController', ['only' => ['index', 'show']]);
Route::resource('orders', 'OrderController', ['only' => ['index', 'show', 'update']]);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Options (for AngularJS)
Route::options('api/v1/jobs', function () {});
Route::options('api/v1/orders', function () {});
Route::options('api/v1/auth/login', function () {});
Route::options('api/v1/auth/logout', function () {});
Route::options('api/v1/quotes/{id}/decline', function () {});
Route::options('api/v1/accounts/{id}', function () {});
Route::options('api/v1/devices', function () {});

// Jobs
Route::get('api/v1/jobs',  ['uses' => 'Api\JobController@index']);
Route::post('api/v1/jobs', ['uses' => 'Api\JobController@store']);
Route::post('api/v1/jobs/{id}/messages',  ['uses' => 'Api\JobMessageController@store']);

// Auth
Route::post('api/v1/auth/login', ['uses' => 'Api\AuthController@login']);
Route::post('api/v1/auth/logout', ['uses' => 'Api\AuthController@logout']);
Route::post('api/v1/auth/password/email', ['uses' => 'Api\AuthController@forgotPassword']);
Route::get('api/v1/auth/password/resetview', ['uses' => 'Api\AuthController@resetPasswordView']);
Route::post('api/v1/auth/password/reset', ['uses' => 'Api\AuthController@resetPassword']);

// Quotes
Route::post('api/v1/quotes/{id}/decline',  ['uses' => 'Api\QuoteController@decline']);
Route::get('api/v1/quotes/{id}/orders', ['uses' => 'Api\QuoteOrderController@index']);
Route::get('api/v1/quotes/{quoteNumber}/checkout', ['uses' => 'Api\QuoteController@checkout']);

// Orders
Route::get('api/v1/orders',  ['uses' => 'Api\OrderController@index']);

// Accounts
Route::post('api/v1/accounts/{id}',  ['uses' => 'Api\AccountController@update']);
Route::post('api/v1/accounts',  ['uses' => 'Api\AccountController@store']);

// Devices
Route::post('api/v1/devices', 'Api\DeviceController@register');

/*
|--------------------------------------------------------------------------
| Implicit Controller Routes
|--------------------------------------------------------------------------
*/

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
