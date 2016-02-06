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
 

Route::get('/', function () {
    return redirect('admin/login/');
});

Route::get('/secret', 'Test@makeSuperAdmin'); 
Route::get('/sms', 'Test@makeCurlSms'); 

//  --------------------- Customer App ------------------------------------------------
// Customer API Authentication
Route::post('api/customer/fb/login', 'Auth\AuthController@fbLogin');
Route::post('api/customer/google/login', 'Auth\AuthController@googleLogin');
Route::post('api/customer/register', 'Auth\AuthController@postCustomerRegister');

Route::post('api/customer/validateOtp', 'ValidateMobileController@validateOtp');
Route::post('api/customer/sendOtp', 'ValidateMobileController@sendCustomerOtp');

Route::post('customer/check', 'Test@postTest');

Route::get('api/cities', 'ElementService@getCities');
Route::get('api/states', 'ElementService@getStates');
Route::get('api/Countries', 'ElementService@getCountries');

Route::group(['prefix' => 'api/customer/v1', 'middleware' => ['api:customer']], function() {
    Route::post('/tags', 'CustomerService@getTags'); 
    Route::post('/offers', 'CustomerService@getOffers');
    Route::post('/favourite','CustomerService@makeFavoutite');
    Route::post('/vote','CustomerService@makeVote');
    //Route::post('/validateOtp','CustomerService@validateOtp');
    //Route::post('/resendOtp','CustomerService@resendOtp');
});


//  --------------------- Merchant App ------------------------------------------------

Route::post('api/merchant/login', 'Auth\AuthController@postMerchantLogin');
Route::post('api/merchant/register', 'Auth\AuthController@postMerchantRegister');
Route::post('api/merchant/validateOtp', 'ValidateMobileController@validateOtp');
Route::post('api/merchant/sendOtp', 'ValidateMobileController@sendMerchantOtp');

Route::group(['prefix' => 'api/merchant/v1', 'middleware' => ['api:merchant']], function() {
    Route::post('/add/store','MerchantService@postStore');
    Route::post('/add/store/address','MerchantService@addStoreAddress');
    Route::post('/tags', 'MerchantService@getTags'); 
    Route::post('/add/offer', 'MerchantService@addOffer'); 
    Route::post('/edit/store', 'MerchantService@editStore'); 
    Route::post('/edit/store/address', 'MerchantService@editStoreAddress'); 
    Route::post('/edit/offer', 'MerchantService@editOffer'); 
    //Route::post('/validateOtp','MerchantService@validateOtp');
   // Route::post('/resendOtp','MerchantService@resendOtp');
    Route::post('/offers','MerchantService@getStoreOffers');
    Route::post('/store/details','MerchantService@getStoreDetails');
    Route::post('/profile/update' , 'MerchantService@editProfile');
    Route::post('/updated/validateOtp' , 'MerchantService@validateUpdatedMobileOtp');
    Route::post('/changepassword' , 'MerchantService@changePassword');
    Route::post('/mobile/update' , 'MerchantService@editMobile');
});

 

 


 

//  --------------------- Admin --------------------------------------------------------
// Admin Authentication routes...
Route::get('admin/login', 'Auth\AuthController@getLogin');
Route::post('admin/login', 'Auth\AuthController@postLogin');
Route::get('admin/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('admin/register', 'Auth\AuthController@getRegister');
Route::post('admin/register', 'Auth\AuthController@postRegister');

Route::get('admin/dashboard', 'Admin\AdminController@getDashboard');

Route::get('admin/users/{status}', 'Admin\AdminController@getUsers');
Route::get('admin/users/role/{type}', 'Admin\AdminController@getTypeUsers');
Route::get('admin/user/{id}', 'Admin\AdminController@getSingleUser');
Route::get('admin/user/{id}/edit', 'Admin\AdminController@getSingleUserEdit');
Route::get('admin/user/{id}/addstore', 'Admin\AdminController@getAddStore');
Route::get('admin/user/new/add', 'Admin\AdminController@getAddUser');
Route::post('admin/user/update', 'Admin\AdminController@updateUser');
Route::post('admin/user/new/add', 'Admin\AdminController@addUser');

Route::get('admin/search/users', 'Admin\AdminController@searchUsers');
Route::get('admin/search/stores', 'Admin\AdminController@searchStores');
Route::get('admin/search/offers', 'Admin\AdminController@searchOffers');


Route::post('admin/store/add', 'Admin\AdminController@addStore');

Route::get('admin/stores/{type}', 'Admin\AdminController@getStores');
Route::get('admin/stores/category/{id}', 'Admin\AdminController@getCategoryStores');
Route::get('admin/store/{id}', 'Admin\AdminController@getSingleStore');
Route::get('admin/store/{id}/offers/{period}', 'Admin\AdminController@getStoreOffers');
Route::get('admin/store/{id}/edit', 'Admin\AdminController@getEditStore');
Route::post('admin/store/update', 'Admin\AdminController@updateStore');

Route::get('admin/store/{id}/addoffer', 'Admin\AdminController@getAddOffer');
Route::post('admin/offer/add', 'Admin\AdminController@addOffer');

Route::get('admin/offers/{period}', 'Admin\AdminController@getOffers');
Route::get('admin/offer/{id}', 'Admin\AdminController@getSingleOffer');
Route::get('admin/offer/{id}/edit', 'Admin\AdminController@getEditOffer');
Route::get('admin/offer/{id}/delete', 'Admin\AdminController@deleteOffer');
Route::post('admin/offer/update', 'Admin\AdminController@updateOffer');

Route::get('admin/elements', 'Admin\AdminController@getElements');
Route::get('admin/element/add/{element}', 'Admin\AdminController@getAddElement');
Route::get('admin/element/edit/{id}/{element}', 'Admin\AdminController@getEditElement');
Route::post('admin/element/add/{element}', 'Admin\AdminController@addElement');
Route::post('admin/element/edit/{element}', 'Admin\AdminController@editElement');


