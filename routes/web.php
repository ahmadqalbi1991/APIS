<?php

Route::group(['middleware' => 'customer_auth'], function () {
    Route::get('/', 'DashboardController@home')->name('home');
    Route::get('/reports', 'DashboardController@reports')->name('reports');
    Route::get('/my-assets', 'DashboardController@myAssets')->name('assets');
    Route::get('/my-locations', 'DashboardController@myLocations')->name('locations');
    Route::get('/my-documents', 'DashboardController@docs')->name('docs');
    Route::get('/my-orders', 'DashboardController@orders')->name('orders');
    Route::get('/my-asset/{id}', 'DashboardController@assetDetail')->name('asset_detail');
    Route::get('/download-report/{id}', 'DashboardController@downloadReport')->name('download-report');
    Route::post('/import-assets', 'DashboardController@importMyAssets')->name('import-assets');
    Route::get('/export-assets', 'DashboardController@exportMyAssets')->name('export-assets');
});
Route::get('/customer/login', 'DashboardController@showLogin')->name('customer-login');
Route::post('/customer/post-login', 'DashboardController@doLogin')->name('customer-post-login');
Route::get('/verify', 'DashboardController@verifyUser')->name('verifyUser');

Route::group(['as' => 'admin.', 'prefix' => '/admin', 'middleware' => ['admin_auth']], function () {
    Route::get('dashboard', 'Admin\AdminController@index')->name('dashboard');
    Route::get('customers', 'Admin\AdminController@customers')->name('customers');
    Route::get('send-email-customer/{id}', 'Admin\CustomerController@sendEmail')->name('send-email');
    Route::get('import-customers', 'Admin\AdminController@importContacts')->name('import-customers');
    Route::post('add-customer-email', 'Admin\AdminController@updateCustomerEmail')->name('update-customer-email');
    Route::get('chain-of-custody', 'Admin\AdminController@chainOfCustody')->name('chainOfCustody');
    Route::get('add-chain-of-custody', 'Admin\AdminController@addChainOfCustody')->name('chainOfCustodyCreate');
    Route::get('edit-chain-of-custody/{id}', 'Admin\AdminController@editChainOfCustody')->name('chainOfCustodyEdit');
    Route::get('delete-chain-of-custody/{id}', 'Admin\AdminController@deleteChainOfCustody')->name('chainOfCustodyDelete');
    Route::post('save-chain-of-custody', 'Admin\AdminController@storeCustody')->name('storeCustody');
    Route::post('update-chain-of-custody/{id}', 'Admin\AdminController@updateCustody')->name('updateCustody');
    Route::get('/document-types', 'Admin\AdminController@docTypes')->name('docTypes');
    Route::get('/document-type/{id}', 'Admin\AdminController@editDocTypes')->name('docTypesEdit');
    Route::get('/delete-document-type/{id}', 'Admin\AdminController@deleteDocTypes')->name('docTypesDelete');
    Route::get('/generate-random-doc-number/{id}', 'Admin\AdminController@generateRandomDocNumber')->name('generateRandomDocNumber');
    Route::post('/save-doc-type', 'Admin\AdminController@saveDocType')->name('save-doc-type');
    Route::post('/update-doc-type/{id}', 'Admin\AdminController@updateDocType')->name('updateDocType');
    Route::get('/documents', 'Admin\AdminController@docs')->name('documents');
    Route::get('/edit-documents/{id}', 'Admin\AdminController@editDocs')->name('editDocuments');
    Route::get('/delete-document/{id}', 'Admin\AdminController@deleteDoc')->name('deleteDocuments');
    Route::post('/documents', 'Admin\AdminController@saveDoc')->name('save-doc');
    Route::post('/update-doc/{id}', 'Admin\AdminController@updateDoc')->name('update-doc');
    Route::group(['as' => 'assets.', 'prefix' => 'assets'], function () {
        Route::get('/', 'Admin\AssetsController@index')->name('index');
        Route::get('/add-asset', 'Admin\AssetsController@create')->name('create');
        Route::get('/edit-asset/{id}', 'Admin\AssetsController@edit')->name('edit');
        Route::get('/delete-asset/{id}', 'Admin\AssetsController@delete')->name('delete');
        Route::post('/update-asset/{id}', 'Admin\AssetsController@update')->name('update');
        Route::post('/save-asset', 'Admin\AssetsController@store')->name('store');
        Route::post('import-assets', 'Admin\AssetsController@importAssets')->name('import-assets');
    });
    Route::group(['as' => 'customers.', 'prefix' => 'customers'], function () {
        Route::get('/', 'Admin\CustomerController@index')->name('index');
        Route::get('/add-customer', 'Admin\CustomerController@create')->name('create');
        Route::get('/edit-customer/{id}', 'Admin\CustomerController@edit')->name('edit');
        Route::post('/update-customer/{id}', 'Admin\CustomerController@update')->name('update');
        Route::post('/save-customer', 'Admin\CustomerController@save')->name('save');
        Route::get('/customer-address', 'Admin\CustomerController@getAddresses')->name('get-addresses');
        Route::get('/delete-customer/{id}', 'Admin\CustomerController@delete')->name('delete');
        Route::get('/delete-company/{id}', 'Admin\CustomerController@deleteCompany')->name('delete-company');
    });
    Route::group(['as' => 'orders.', 'prefix' => 'orders'], function () {
        Route::get('/', 'Admin\OrderController@index')->name('index');
        Route::get('/add-order', 'Admin\OrderController@create')->name('create-order');
        Route::post('/save-order', 'Admin\OrderController@store')->name('store');
        Route::get('/get-order-customer', 'Admin\OrderController@getCustomerId')->name('get-customer-id');
    });
});

Route::get('get-states', function () {
    $id = request()->get('id');
    $options = '<option value="">Select State</option>';
    $states = \App\State::where('country_id', $id)->get();
    foreach ($states as $state) {
        $options .= '<option value="' . $state->id . '">' . $state->name . '</option>';
    }

    return $options;
})->name('get-states');

Route::get('get-cities', function () {
    $id = request()->get('id');
    $options = '<option value="">Select City</option>';
    $cities = \App\City::where('state_id', $id)->get();
    foreach ($cities as $city) {
        $options .= '<option value="' . $city->id . '">' . $city->name . '</option>';
    }

    return $options;
})->name('get-cities');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('customer-login', ['type' => 'customer']);
})->name('logout');

Auth::routes();

Route::get('/add-admin', function () {
    $user['name'] = 'Admin';
    $user['email'] = 'admin@admin.com';
    $user['password'] = bcrypt("123456789");
    $user['is_admin'] = 1;
    $user['role'] = 'admin';
    $user['is_verified'] = 1;
    $user['email_sent'] = 1;
    $user['is_active'] = 1;

    \App\User::create($user);
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
    echo "Done";
});
