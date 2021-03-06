<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('HomeController@index');
Route::get('/menu', 'HomeController@menu')->name('HomeController@menu');
Route::get('/menu_invoice', 'HomeController@menu_invoice')->name('HomeController@menu_invoice');
Route::get('/menu_config', 'HomeController@menu_config')->name('HomeController@menu_config');
Route::post('/mission/new', 'MissionController@mission_submit')->name('mission_submit');
Route::get('/mission/new', 'MissionController@mission_new')->name('MissionController@mission_new');
Route::get('/mission/new/{date}', 'MissionController@mission_newDate');
Route::get('/mission/view', 'MissionController@viewMissions')->name('viewMissions');
Route::get('/mission/view/{id}', 'MissionController@viewMission');
Route::get('/mission/view/{id}/driver', 'MissionController@viewMissionDriver');
Route::get('/mission/view/{id}/customer', 'MissionController@viewMissionCustomer');
Route::get('/mission/viewNoDriver', 'MissionController@viewNoDriver')->name('viewNoDriver');
Route::get('/mission/viewNoDeliveryNote', 'MissionController@viewNoDeliveryNote')->name('viewNoDeliveryNote');
Route::get('/mission_overview/{id}', 'MissionController@overview')->name('overview');
Route::get('/customer', 'DriverController@customer')->name('customer');
Route::get('/bill1', 'BillController@createBill1');
Route::get('/bill2', 'BillController@createBill2');
Route::post('/saveBill', 'MissionController@saveBill');
Route::get('/invoices/{id}', 'MissionController@listInvoices');
Route::get('/invoicesPaid/{id}', 'MissionController@paidInvoices');
Route::get('/bill/{id}', 'MissionController@showBill');
Route::get('/bill/{id}/printPDF', 'BillController@printPDF');
Route::get('/payBill/{id}', 'BillController@payBill');
Route::get('/credits/{company}', 'CreditController@listForCredits')->name('listForCredits');
Route::post('/saveCredit', 'CreditController@saveCredit')->name('saveCredit');
Route::get('/listCredits/{company}', 'CreditController@listCredits')->name('listCredits');
Route::get('/payCredits/{company}', 'CreditController@payCredits')->name('payCredits');
Route::get('/payCredit/{id}', 'CreditController@payCredit')->name('payCredit');
Route::get('/listing', 'ListingController@listForListings');
Route::post('/listingSave', 'ListingController@listingSave')->name('listingSave');
Route::get('/listings', 'ListingController@listListings');
Route::get('/drivers/{id}', 'DriverController@edit');
Route::get('/drivers', 'DriverController@new')->name('newDriver');
Route::get('/drivers/{id}/delete', 'DriverController@driverDelete')->name('deleteDriver');
Route::post('/drivers', 'DriverController@submit');
Route::get('/unpaidMissions/{company}', 'MissionController@unpaidMissions');
Route::get('payMission/{id}', 'MissionController@payMission');
Route::get('/missionsPayDriver/{company}', 'MissionController@payDriverList');
Route::get('/mission/{id}/payDriver', 'MissionController@PayDriver');
Route::get('/mission/{id}/delete', 'MissionController@mission_delete');
Route::get('/mission/{id}/details', 'MissionController@overview');
Route::get('/mission/{id}/edit', 'MissionController@edit');
Route::get('/mission/calendar', 'MissionController@calendar')->name('calendar');
Route::get('/mission/calendar/{lastMissionID}', 'MissionController@calendar')->name('calendar');
Route::get('/credit/{id}/edit', 'CreditController@edit');
Route::get('/credit/{id}/delete/{mission}', 'CreditController@deleteMission');
Route::get('/credit/{id}/add/{mission}', 'CreditController@addMission');
Route::get('/credit/{id}/printPDF/{taxes}', 'CreditController@printPDF');
Route::get('/chart/', 'ChartController@missionsWithoutDates');
Route::post('/chart/', 'ChartController@missions');
Route::get('/chart/{company}', 'ChartController@report');
Route::get('/listing/{id}/edit', 'ListingController@edit');
Route::get('/listing/{id}/delete/{mission}', 'ListingController@deleteMission');
Route::get('/listing/{id}/add/{mission}', 'ListingController@addMission');
Route::get('/listing/{id}/printPDF', 'ListingController@printPDF');


Route::get('rechnung/new/{customer}', 'RechnungController@new' );
Route::post('rechnung/new', 'RechnungController@submit');
Route::get('rechnung/add/{rechnung}/{mission}', 'RechnungController@addMission');
Route::get('rechnung/sub/{rechnung}/{mission}', 'RechnungController@subMission');
Route::get('rechnung/list/{company}', 'RechnungController@list');
Route::get('rechnung/edit/{id}', 'RechnungController@edit');
Route::get('rechnung/edit/{id}/delete', 'RechnungController@delete');
Route::get('rechnung/payList/{company}', 'RechnungController@payList');
Route::get('rechnung/pay/{rechnungs_id}', 'RechnungController@pay');


Route::get('dekra/new_customer/{id}/delete', 'HomeController@customerDelete');
Route::get('/dekra/new_customer', 'DriverController@newCustomer');
Route::get('/dekra/new_customer/{id}', 'DriverController@editCustomer');
Route::post('/dekra/save_customer', 'DriverController@saveCustomer');
Route::get('/uploadfile','UploadFileController@index') ;
Route::post('/uploadfile','UploadFileController@showUploadFile');
Route::get('/config','HomeController@config');
Route::post('/config','HomeController@configSafe');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
