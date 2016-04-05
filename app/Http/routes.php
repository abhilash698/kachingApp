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
    return redirect('/merchant/login');
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
Route::get('api/appElements', 'ElementService@appElements');

Route::get('api/allElements', 'ElementService@allElements');
Route::get('api/allElementsv2', 'ElementService@allElementsV2');

Route::group(['prefix' => 'api/customer/v1', 'middleware' => ['api:customer']], function() {
    Route::post('/tags', 'CustomerService@getTags'); 
    Route::post('/offers', 'CustomerService@getOffers');
    Route::post('/offers/search', 'CustomerService@searchOffers');
    Route::post('/favourite','CustomerService@makeFavoutite');
    Route::post('/vote','CustomerService@makeVote');
    Route::post('/favOffers','CustomerService@userFavOffers');
    Route::post('/profile','CustomerService@userProfile');
    Route::post('/profile/edit','CustomerService@editProfile');
    //Route::post('/validateOtp','CustomerService@validateOtp');
    //Route::post('/resendOtp','CustomerService@resendOtp');
});


//  --------------------- Merchant App ------------------------------------------------

Route::post('api/merchant/login', 'Auth\AuthController@postMerchantLogin');
Route::post('api/merchant/register', 'Auth\AuthController@postMerchantRegister');
Route::post('api/merchant/validateOtp', 'ValidateMobileController@validateOtp');
Route::post('api/merchant/sendOtp', 'ValidateMobileController@sendMerchantOtp');

Route::post('api/merchant/forgotOtp', 'ValidateMobileController@forgotPasswordOtp');
Route::post('api/merchant/verifyForgotOtp', 'ValidateMobileController@verifyForgotOtp');
Route::post('api/merchant/changepassword', 'ValidateMobileController@changePassword');

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

Route::group(['prefix' => 'api/merchant/v2', 'middleware' => ['api:merchant']], function() {
    Route::post('/add/store','V2\MerchantServiceV2@postStore');
    Route::post('/add/store/address','V2\MerchantServiceV2@addStoreAddress');
    Route::post('/tags', 'V2\MerchantServiceV2@getTags'); 
    Route::post('/add/offer', 'V2\MerchantServiceV2@addOffer'); 
    Route::post('/edit/store', 'V2\MerchantServiceV2@editStore'); 
    Route::post('/edit/store/address', 'V2\MerchantServiceV2@editStoreAddress'); 
    Route::post('/edit/offer', 'V2\MerchantServiceV2@editOffer'); 
    Route::post('/offers','V2\MerchantServiceV2@getStoreOffers');
    Route::post('/store/details','V2\MerchantServiceV2@getStoreDetails');
    Route::post('/profile/update' , 'V2\MerchantServiceV2@editProfile');
    Route::post('/updated/validateOtp' , 'V2\MerchantServiceV2@validateUpdatedMobileOtp');
    Route::post('/changepassword' , 'V2\MerchantServiceV2@changePassword');
    Route::post('/mobile/update' , 'V2\MerchantServiceV2@editMobile');
    Route::post('/linked/offers' , 'V2\MerchantServiceV2@getLinkedStoreOffers');
    Route::post('/getCryptToken' , 'V2\MerchantServiceV2@getCryptToken');

}); 

 

 


 

//  --------------------- Admin --------------------------------------------------------
// Admin Authentication routes...
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');
// Registration routes...
/*Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');*/


Route::group(['prefix' => 'admin', 'middleware' => ['role:superAdmin']], function() {
    Route::get('/dashboard', function () {
        return redirect('/dashboard');
    });

    Route::get('/addSuperMerchant', 'Admin\AdminController@getAddSuperMerchant');
    Route::post('/add/supermerchant', 'Admin\AdminController@addSuperMerchant');
    Route::post('/edit/supermerchant', 'Admin\AdminController@editSuperMerchant');

    Route::get('/superMerchants', 'Admin\AdminController@getSuperMerchantsList');
    Route::get('/superMerchant/{id}/edit', 'Admin\AdminController@getSuperMerchantEdit');
    Route::get('/superMerchant/{id}/delete', 'Admin\AdminController@getSuperMerchantDelete');


    
    Route::get('/dashboard', 'Admin\AdminController@getDashboard');

    Route::get('/users/{status}', 'Admin\AdminController@getUsers');
    Route::get('/users/role/{type}', 'Admin\AdminController@getTypeUsers');
    Route::get('/user/{id}', 'Admin\AdminController@getSingleUser');
    Route::get('/user/{id}/delete', 'Admin\AdminController@deleteUser');
    Route::get('/user/{id}/edit', 'Admin\AdminController@getSingleUserEdit');
    Route::get('/user/{id}/addstore', 'Admin\AdminController@getAddStore');
    Route::get('/user/new/add', 'Admin\AdminController@getAddUser');
    Route::post('/user/update', 'Admin\AdminController@updateUser');
    Route::post('/user/new/add', 'Admin\AdminController@addUser');

    Route::get('/search/users', 'Admin\AdminController@searchUsers');
    Route::get('/search/stores', 'Admin\AdminController@searchStores');
    Route::get('/search/offers', 'Admin\AdminController@searchOffers');


    Route::post('/store/add', 'Admin\AdminController@addStore');

    Route::get('/stores/{type}', 'Admin\AdminController@getStores');
    Route::get('/stores/category/{id}', 'Admin\AdminController@getCategoryStores');
    Route::get('/store/{id}', 'Admin\AdminController@getSingleStore');
    Route::get('/store/{id}/offers/{period}', 'Admin\AdminController@getStoreOffers');
    Route::get('/store/{id}/edit', 'Admin\AdminController@getEditStore');
    Route::post('/store/update', 'Admin\AdminController@updateStore');

    Route::get('/store/{id}/addoffer', 'Admin\AdminController@getAddOffer');
    Route::post('/offer/add', 'Admin\AdminController@addOffer');

    Route::get('/offers/{period}', 'Admin\AdminController@getOffers');
    Route::get('/offer/{id}', 'Admin\AdminController@getSingleOffer');
    Route::get('/offer/{id}/edit', 'Admin\AdminController@getEditOffer');
    Route::get('/offer/{id}/delete', 'Admin\AdminController@deleteOffer');
    Route::post('/offer/update', 'Admin\AdminController@updateOffer');

    Route::get('/elements', 'Admin\AdminController@getElements');
    Route::get('/element/add/{element}', 'Admin\AdminController@getAddElement');
    Route::get('/element/edit/{id}/{element}', 'Admin\AdminController@getEditElement');
    Route::post('/element/add/{element}', 'Admin\AdminController@addElement');
    Route::post('/element/edit/{element}', 'Admin\AdminController@editElement');
    Route::get('/tag/{id}/delete', 'Admin\AdminController@deleteTag');

});

Route::get('merchant/login', 'Auth\AuthController@getMerchantLogin');
Route::get('merchant/forgot/mobile', 'Merchant\MerchantController@getForgotMobile');
Route::post('merchant/forgot/mobile', 'Merchant\MerchantController@postForgotMobile');
Route::post('merchant/forgot/otp', 'Merchant\MerchantController@postForgotOtp');
Route::post('merchant/forgot/changepassword', 'Merchant\MerchantController@postchangepassword');

Route::group(['prefix' => 'merchant', 'middleware' => ['role:merchant']], function() {
    Route::get('/dashboard', 'Merchant\MerchantController@getDashboard');
    Route::post('/addOffer', 'Merchant\MerchantController@addOffer');
    Route::post('/editOffer', 'Merchant\MerchantController@editOffer');
    Route::post('/disableOffer', 'Merchant\MerchantController@disableOffer');
    Route::get('/profile', 'Merchant\MerchantController@getProfile');
    Route::get('/about', 'Merchant\MerchantController@getAbout');
    Route::get('/support', 'Merchant\MerchantController@getService');

    Route::get('/store', 'Merchant\MerchantController@getStore');
    Route::get('/store/edit', 'Merchant\MerchantController@getEditStore');
    Route::post('/store/edit', 'Merchant\MerchantController@editStore');
    Route::get('/profile/edit', 'Merchant\MerchantController@getUserEdit');
    Route::post('/profile/edit', 'Merchant\MerchantController@editUser');
    Route::post('/profile/changepassword', 'Merchant\MerchantController@changePassword');
    Route::post('/profile/sendOtp', 'Merchant\MerchantController@sendOtp');
    Route::post('/profile/validateOtp', 'Merchant\MerchantController@validateOtp');
    
});    


