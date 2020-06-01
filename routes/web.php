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
// SSLCOMMERZ Start

Route::post('/pay', 'Userend\SslCommerzPaymentController@index')->name('pay');

Route::post('/success', 'Userend\SslCommerzPaymentController@success');
Route::post('/fail', 'Userend\SslCommerzPaymentController@fail');
Route::post('/cancel', 'Userend\SslCommerzPaymentController@cancel');

Route::post('/ipn', 'Userend\SslCommerzPaymentController@ipn');
/* ======================================== Website  ================================================ */
Route::get('/','website\websiteController@index')->name('website.home');
Route::get('/about_us','website\websiteController@about')->name('website.about');
Route::get('/offers','website\websiteController@offers')->name('website.offers');
Route::get('/termsandconditions','website\websiteController@termsandconditions')->name('website.termsandconditions');
Route::get('/contact_us','website\websiteController@contact_us')->name('website.contact');
Route::post('/submitContact','website\websiteController@submitContact')->name('website.submitContact');
/* ====================================== Website end  ============================================== */
/* ====================================================== Ecommerce Frontend  ============================================================== */
Route::get('/ecommerce', 'Userend\pagesController@home')->name('pages.home');
Route::get('/products', 'Userend\pagesController@products')->name('pages.products');
Route::get('/single_product/{id}', 'Userend\pagesController@single_product')->name('pages.single_product');
Route::get('/single', 'Userend\pagesController@single')->name('pages.single');
Route::get('/subCatgProductSearch/{id}', 'Userend\pagesController@subCatgProductSearch')->name('pages.subCatgProductSearch');
Route::get('/offerSearchByTitle/{title}', 'Userend\pagesController@offerSearchByTitle')->name('pages.offerSearchByTitle');
Route::get('/allOfferSearch', 'Userend\pagesController@allOfferSearch')->name('pages.allOfferSearch');



//  cart
Route::get('/cart', 'Userend\CartController@index')->name('cart.index');
Route::get('/cart/add/{id}', 'Userend\CartController@addItem')->name('cart.add');
Route::get('/cart/delete/{rowId}', 'Userend\CartController@deleteItem')->name('cart.delete');
Route::post('/cart/update', 'Userend\CartController@updateItem')->name('cart.update');
Route::get('/cart_destroy',function (){Cart::destroy();});

Route::get('/generatePdf', 'Userend\pagesController@generatePdf')->name('generatePdf');


/* ====================================================== Frontend end   ============================================================== */
/* ====================================================== customer auth   ============================================================== */
Route::get('/customer/login', 'CustomerAuth\LoginController@showLoginForm')->name('customer.login');
Route::post('/customer/login', 'CustomerAuth\LoginController@login');
Route::get('/customer/register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('customer.register');
Route::post('/customer/register', 'CustomerAuth\RegisterController@register');


Route::post('/customer/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
Route::get('/customer/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('customer.password.request');
Route::post('/customer/password/reset', 'CustomerAuth\ResetPasswordController@reset')->name('customer.password.update');
Route::get('/customer/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm')->name('customer.password.reset');

Route::group(['middleware'=>['customerCheck']], function(){
Route::get('/customer/home', 'Userend\customerController@index')/*->name('home')*/;



//xahid
    Route::get('/myProfile', 'Userend\customerController@myProfile')->name('pages.myProfile');
    Route::get('/myProfile/edit/{id}', 'Userend\customerController@editMyProfile')->name('pages.editMyProfile');
    Route::post('/myProfile/edit', 'Userend\customerController@profile_edit')->name('pages.profile_edit');

    Route::get('/myOrder/{id}', 'Userend\orderController@myOrder')->name('pages.myOrder');
    Route::get('/confirmedOrderDetails/{id}', 'Userend\orderController@confirmedOrderDetails')->name('confirmedOrderDetails');
    Route::get('/generateInvoice/{id}', 'Userend\orderController@generateInvoice')->name('generateInvoice_customer');
//xahid

});
/* ====================================================== customer auth end   ============================================================== */
/* ====================================================== Backend   =================================================================== */
Auth::routes();
Route::get('/vendors','Vendor\vendorController@index');
Route::group(['middleware'=>['superVendorCheck']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
/* ======== normalVendor   =================================================================== */

    Route::group(['middleware'=>['vendorCheck']], function(){
        //dashboard
        Route::get('/dashboard','Vendor\normalVendorController@index')->name('nvdashboard');
//dashboard #
//category management
        Route::get('/category_management','Vendor\normalVendorController@categoryManagementView')->name('categoryManagementView');
        Route::post('/category_management','Vendor\normalVendorController@categoryAdd')->name('categoryAdd');
        Route::get('/category_management/sub/{pid}','Vendor\normalVendorController@subCategoryView')->name('subCategoryView');
        Route::get('/category_management/remove/{id}','Vendor\normalVendorController@categoryRemove')->name('categoryRemove');
        Route::post('/category_management/update','Vendor\normalVendorController@categoryUpdate')->name('categoryUpdate');
//category managment #
//brand management
        Route::get('/brand_management','Vendor\normalVendorController@brandManagementView')->name('brandManagementView');
        Route::post('/brand_management','Vendor\normalVendorController@brandAdd')->name('brandAdd');
        Route::get('/brand_management/edit/{id}','Vendor\normalVendorController@brandManagementEdit')->name('brandManagementEdit');
        Route::post('/brand_management/update','Vendor\normalVendorController@brandUpdate')->name('brandUpdate');
        Route::get('/brand_management/remove/{id}','Vendor\normalVendorController@brandRemove')->name('brandRemove');
//brand management #
//product management
        Route::get('/product_management','Vendor\normalVendorController@productManagementView')->name('productManagementView');
        Route::post('/product_management','Vendor\normalVendorController@productAdd')->name('productAdd');
        Route::get('/product_management/edit/{id}','Vendor\normalVendorController@productManagementEdit')->name('productManagementEdit');
        Route::post('/product_management/update','Vendor\normalVendorController@productUpdate')->name('productUpdate');
        Route::get('/product_management/remove/{id}','Vendor\normalVendorController@productRemove')->name('brandRemove');
//product management #
////inventory management
        Route::get('/inventory_management','Vendor\normalVendorController@inventoryManagementView')->name('inventoryManagementView');
//inventory management #
//sales management
        Route::get('/sales_management','Vendor\normalVendorController@sales')->name('sales');
        Route::post('/sales_management','Vendor\normalVendorController@salesReport')->name('salesReport');
//sales management #

    });
//offer management
        Route::get('/offer_emanagement','Vendor\normalVendorController@offerManagementView')->name('offerManagementView');
        Route::post('/offer_management','Vendor\normalVendorController@offerAdd')->name('offerAdd');
        Route::get('/offer_management/edit/{id}','Vendor\normalVendorController@offerManagementEdit')->name('offerManagementEdit');
        Route::post('/offer_management/update','Vendor\normalVendorController@offerUpdate')->name('offerUpdate');
        Route::get('/offer_management/remove/{id}','Vendor\normalVendorController@offerRemove')->name('offerRemove');
//offer management #

//order management
        Route::post('/order_management/daterange','Vendor\normalVendorController@orderReport')->name('orderReport');
        Route::get('/Processingorders','Vendor\normalVendorController@processingOrderView')->name('processingOrderView');
        Route::get('/Shippingorders','Vendor\normalVendorController@shippingOrderView')->name('shippingOrderView');
        Route::get('/Deliveredorders','Vendor\normalVendorController@deliveredOrderView')->name('deliveredOrderView');
        Route::get('/pending_orders','Vendor\normalVendorController@pendingOrderView')->name('pendingOrderView');
        Route::get('/orders/remove/{id}','Vendor\normalVendorController@OrderRemove')->name('OrderRemove');
        Route::post('/order_management/shipping','Vendor\normalVendorController@orderShipping')->name('orderShipping');
        Route::get('/order_management/delivered/{id}','Vendor\normalVendorController@orderDelivered')->name('orderDelivered');
        Route::get('/order_management/processing/{id}','Vendor\normalVendorController@orderProcessiong')->name('orderProcessiong');
        Route::get('/failed_orders','Vendor\normalVendorController@failedOrderView')->name('failedOrderView');

        /**/
        Route::get('/order_management/order_details/{id}','Vendor\normalVendorController@order_details')->name('order_details');
        Route::get('/order_management/generateInvoice/{id}', 'Vendor\normalVendorController@generateInvoice')->name('generateInvoice');
        Route::get('/order_management/search', 'Vendor\normalVendorController@search')->name('search');//ajax
        Route::get('/order_management/allorders','Vendor\normalVendorController@allOrders')->name('allOrders');
        Route::post('/order_management/excel','Vendor\normalVendorController@excel')->name('excel');
        Route::post('/order_management/print_count','Vendor\normalVendorController@printCount')->name('printCount');


//order management #
//customer_management
        Route::get('/customer_management','Vendor\normalVendorController@customerList')->name('customerList');
        Route::get('/customer_management/details/{id}','Vendor\normalVendorController@customer_details')->name('customer_details');
        Route::get('/customer_management/search', 'Vendor\normalVendorController@searchCustomer')->name('searchCustomer');//ajax
        Route::get('/customer_management/excel','Vendor\normalVendorController@customerExcel')->name('customerExcel');

//customer_management #

//contact management
        Route::get('/contact_management','Vendor\normalVendorController@contact_management')->name('contact_management');
        Route::get('/contact_details/{id}','Vendor\normalVendorController@contact_details')->name('contact_details');
        Route::get('/contact_delete/{id}','Vendor\normalVendorController@contact_delete')->name('contact_delete');
        Route::get('/contact_processing/{id}','Vendor\normalVendorController@contact_processing')->name('contact_processing');
        Route::get('/contact_solved/{id}','Vendor\normalVendorController@contact_solved')->name('contact_solved');
        Route::get('/contact_cancel/{id}','Vendor\normalVendorController@contact_cancel')->name('contact_cancel');
        Route::post('/contact_note_update','Vendor\normalVendorController@contact_note_update')->name('contact_note_update');
        Route::get('/contact_search','Vendor\normalVendorController@contact_search')->name('contact_search');
//contact management #


///* ======== normalVendor #   =================================================================== */



/* ====================================================== Backend #  =================================================================== */

});
/* ====================================================== Installment start #  =================================================================== */
Route::group(['middleware'=>['normalVendorCheck']], function(){

    Route::get('/installment','Installment\installmentController@index')->name('installment.index');
    Route::get('/installmentProducts','Installment\installmentController@products')->name('installment.products');
    Route::get('/makeOrder/{id}','Installment\installmentController@makeOrder')->name('installment.makeOrder');
    Route::post('/makeOrder','Installment\installmentController@placeOrder')->name('installment.placeOrder');
    Route::get('/searchCustomerForOrder','Installment\installmentController@searchCustomerForOrder')->name('installment.searchCustomerForOrder');

    Route::get('/previousOrders','Installment\installmentController@previousOrders')->name('installment.previousOrders');
    Route::get('/runningOrders','Installment\installmentController@runningOrders')->name('installment.runningOrders');
    Route::get('/updateOrder/{id}','Installment\installmentController@updateOrder')->name('installment.updateOrder');
    Route::get('/updateOrderStatus/{orderId}/{statusId}/{status}/{date}','Installment\installmentController@updateOrderStatus')->name('installment.updateOrderStatus');
    Route::get('/viewNoteDetails','Installment\installmentController@viewNoteDetails')->name('installment.viewNoteDetails');
    Route::post('/updateNote','Installment\installmentController@updateNote')->name('installment.updateNote');

    Route::get('/defaulters','Installment\installmentController@defaulters')->name('installment.defaulters');
    Route::post('/defaultersDateSearch','Installment\installmentController@defaultersDateSearch')->name('installment.defaultersDateSearch');
    Route::get('/viewDefaulterCallNote','Installment\installmentController@viewDefaulterCallNote')->name('installment.viewDefaulterCallNote');
    Route::post('/updateDefaulterCallNote','Installment\installmentController@updateDefaulterCallNote')->name('installment.updateDefaulterCallNote');
    Route::get('/updateDefaulterCallStatus/{orderId}/{status}','Installment\installmentController@updateDefaulterCallStatus')->name('installment.updateDefaulterCallStatus');


    Route::get('/customers','Installment\installmentController@customers')->name('installment.customers');
    Route::get('/addCustomer','Installment\installmentController@addCustomer')->name('installment.addCustomer');
    Route::post('/addCustomer','Installment\installmentController@createCustomer')->name('installment.createCustomer');

    Route::get('/accounts','Installment\installmentController@accounts')->name('installment.accounts');
    Route::get('/accountsPerDate','Installment\installmentController@accountsPerDate')->name('installment.accountsPerDate');
});
/* ====================================================== Installment end #  =================================================================== */

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'cache cleared';
});
Route::get('/updateapp', function()
{
    $exitCode = Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});
