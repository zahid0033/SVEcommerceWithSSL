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

/* ======================================== Website  ================================================ */
Route::get('/','website\websiteController@index')->name('website.home');
Route::get('/about_us','website\websiteController@about')->name('website.about');
/*Route::get('/products','website\websiteController@products')->name('website.products');*/
Route::get('/offers','website\websiteController@offers')->name('website.offers');
Route::get('/contact_us','website\websiteController@contact_us')->name('website.contact');
Route::post('/submitContact','website\websiteController@submitContact')->name('website.submitContact');
/* ====================================== Website end  ============================================== */
/* ====================================================== Frontend  ============================================================== */
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

Route::get('/react', function (){
    return view('react');
});

/* ====================================================== Frontend end   ============================================================== */
/* ====================================================== customer auth   ============================================================== */
Route::get('/customer/login', 'CustomerAuth\LoginController@showLoginForm')->name('customer.login');
Route::post('/customer/login', 'CustomerAuth\LoginController@login');
Route::get('/customer/register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('customer.register');
Route::post('/customer/register', 'CustomerAuth\RegisterController@register');



Route::group(['middleware'=>['customerCheck']], function(){
Route::get('/customer/home', 'Userend\customerController@index')/*->name('home')*/;

Route::post('/customer/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
Route::get('/customer/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('customer.password.request');
Route::post('/customer/password/reset', 'CustomerAuth\ResetPasswordController@reset')->name('customer.password.update');
Route::get('/customer/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm')->name('customer.password.reset');

//xahid
    Route::get('/checkout/{id}', 'Userend\customerController@checkout')->name('pages.checkout');
    Route::get('/myOrder/{id}', 'Userend\customerController@myOrder')->name('pages.myOrder');
    Route::get('/myProfile', 'Userend\customerController@myProfile')->name('pages.myProfile');
    Route::get('/myProfile/edit/{id}', 'Userend\customerController@editMyProfile')->name('pages.editMyProfile');
    Route::post('/myProfile/edit', 'Userend\customerController@profile_edit')->name('pages.profile_edit');
    Route::post('/place_order', 'Userend\orderController@place_order')->name('place_order');
    Route::get('/temp_orders/{id}', 'Userend\orderController@temp_orders')->name('temp_orders');
    Route::post('/paymentConfirm', 'Userend\orderController@paymentConfirm')->name('paymentConfirm');
    Route::get('/paymentSuccess/{id}', 'Userend\orderController@paymentSuccess')->name('paymentSuccess');
    Route::get('/pendingOrderDetails/{id}', 'Userend\orderController@pendingOrderDetails')->name('pendingOrderDetails');
    Route::get('/confirmedOrderDetails/{id}', 'Userend\orderController@confirmedOrderDetails')->name('confirmedOrderDetails');


//xahid

});
/* ====================================================== customer auth end   ============================================================== */
/* ====================================================== Backend   =================================================================== */
Auth::routes();

Route::group(['middleware'=>['normalVendorCheck']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vendors','Vendor\vendorController@index');
/* ======== normalVendor   =================================================================== */
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
//offer management
Route::get('/offer_emanagement','Vendor\normalVendorController@offerManagementView')->name('offerManagementView');
Route::post('/offer_management','Vendor\normalVendorController@offerAdd')->name('offerAdd');
Route::get('/offer_management/edit/{id}','Vendor\normalVendorController@offerManagementEdit')->name('offerManagementEdit');
Route::post('/offer_management/update','Vendor\normalVendorController@offerUpdate')->name('offerUpdate');
Route::get('/offer_management/remove/{id}','Vendor\normalVendorController@offerRemove')->name('offerRemove');
//offer management #
//inventory management
Route::get('/inventory_management','Vendor\normalVendorController@inventoryManagementView')->name('inventoryManagementView');
//inventory management #
//order management
Route::get('/pending_orders','Vendor\normalVendorController@pendingOrderView')->name('pendingOrderView');
Route::get('/orders','Vendor\normalVendorController@OrderView')->name('OrderView');
Route::post('/order_management/cancel','Vendor\normalVendorController@orderCancel')->name('orderCancel');
Route::get('/order_management/proceed/{id}','Vendor\normalVendorController@orderProceed')->name('orderProceed');
Route::get('/order_management/delivered/{id}','Vendor\normalVendorController@orderDelivered')->name('orderDelivered');
Route::post('/order_management/shipping','Vendor\normalVendorController@orderShipping')->name('orderShipping');
Route::get('/order_management/processing/{id}','Vendor\normalVendorController@orderProcessiong')->name('orderProcessiong');
Route::get('/cancel_orders','Vendor\normalVendorController@cancelOrderView')->name('cancelOrderView');
Route::get('/order_management/order_details/{id}','Vendor\normalVendorController@order_details')->name('order_details');
Route::get('/order_management/temp_order_details/{id}','Vendor\normalVendorController@temp_order_details')->name('temp_order_details');
Route::get('/order_management/generateInvoice/{id}', 'Vendor\normalVendorController@generateInvoice')->name('generateInvoice');
Route::get('/due_orders','Vendor\normalVendorController@dueOrderView')->name('dueOrderView');
Route::get('/due_orders/remove/{id}','Vendor\normalVendorController@dueOrderRemove')->name('dueOrderRemove');
Route::post('/order_management/updatePayment','Vendor\normalVendorController@updatePayment')->name('updatePayment');
Route::get('/order_management/search', 'Vendor\normalVendorController@search')->name('search');//ajax
Route::get('/order_management/allorders','Vendor\normalVendorController@allOrders')->name('allOrders');
Route::post('/order_management/daterange','Vendor\normalVendorController@orderReport')->name('orderReport');

//order management #
//customer_management
Route::get('/customer_management','Vendor\normalVendorController@customerList')->name('customerList');
Route::get('/customer_management/details/{id}','Vendor\normalVendorController@customer_details')->name('customer_details');
Route::get('/customer_management/search', 'Vendor\normalVendorController@searchCustomer')->name('searchCustomer');//ajax
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
//sales management
Route::get('/sales_management','Vendor\normalVendorController@sales')->name('sales');
Route::post('/sales_management','Vendor\normalVendorController@salesReport')->name('salesReport');

//sales management #
///* ======== normalVendor #   =================================================================== */


});
/* ====================================================== Backend #  =================================================================== */
