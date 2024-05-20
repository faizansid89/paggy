<?php

use App\Http\Controllers\API\BranchesController;
use App\Http\Controllers\API\CustomerRegisterController;
use App\Http\Controllers\API\FilterController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\API\SystemsettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register-customer', [CustomerRegisterController::class, 'customerRegister']);
Route::post('login-customer', [CustomerRegisterController::class, 'customerLogin']);
Route::post('customer-forgot-password', [CustomerRegisterController::class, 'customerForgotPassword']);
Route::post('verifyOTP',[CustomerRegisterController::class, 'verifyOTP']);
Route::post('resetPassword',[CustomerRegisterController::class, 'resetPassword']);


Route::group(['middleware' => 'auth.token'], function () {

    Route::post('customer-logout', [CustomerRegisterController::class, 'customerLogout']);

});
Route::put('update_address/{address_id}',[BranchesController::class, 'update_address']);


Route::get('text_type/{id}', 'App\Http\Controllers\API\SystemsettingController@text_type');

Route::post('feedback', [SystemsettingController::class, 'feedback']);
Route::post('customerEditProfile', [CustomerRegisterController::class, 'customerEditProfile']);
Route::post('change_password', [CustomerRegisterController::class, 'change_password']);

Route::get('address', [BranchesController::class, 'address']);

Route::post('add_address',[BranchesController::class, 'add_address']);

Route::get('profile', [CustomerRegisterController::class, 'profile']);
Route::get('faq', [SystemsettingController::class, 'faq']);


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//--------------------------- For Branch Api  ---------------------------
Route::get('getDetails', [ProductsController::class, 'get_details']);

// purchases purchase_details ka data branch main jaye ga //


// get data from branch to admin
Route::get('sendAllData/{branch_id}', [SyncController::class, 'sendAllData']);
Route::get('sendCustomer', [SyncController::class, 'sendCustomer']);


Route::post('receive_items', [SyncController::class, 'receiveItems']);
Route::post('purchases', [SyncController::class, 'purchases']);
Route::post('inventory', [SyncController::class, 'inventory']);
Route::post('sales', [SyncController::class, 'sales']);
Route::post('return_sales', [SyncController::class, 'return_sales']);
Route::post('opening_balance', [SyncController::class, 'opening_balance']);
Route::post('miss_sale', [SyncController::class, 'miss_sale']);

Route::post('sync_logs', [SyncController::class, 'sync_logs']);

Route::post('saleItems', [SyncController::class, 'saleItems']);
Route::post('customer', [SyncController::class, 'customer']);
Route::post('user', [SyncController::class, 'user']);
//////////////////////////////////////////////////////

// Route::get('categories','App\Http\Controllers\API\CategoryController@allcategories');

Route::get('store/{id}','App\Http\Controllers\API\ProductController@shop_branch');
Route::get('nearby_store/{id}','App\Http\Controllers\API\ProductController@nearby_store');
Route::get('store/{id}/product/{pro}','App\Http\Controllers\API\ProductController@store');

Route::get('all_product','App\Http\Controllers\API\ProductController@all_product');
Route::get('all_product_by_branch/{branch_id}','App\Http\Controllers\API\ProductController@all_product_by_branch');


Route::get('category_product/{id}','App\Http\Controllers\API\ProductController@category_product');
Route::get('product_unit_status/{id}','App\Http\Controllers\API\ProductController@product_unit_status');

Route::get('branch_product_pagi/{id}','App\Http\Controllers\API\ProductController@branch_product_pagi');
Route::get('top_selling/{id}','App\Http\Controllers\API\ProductController@top_selling');
Route::get('top_selling_by_branch/{id}/{branch_id}','App\Http\Controllers\API\ProductController@top_selling_by_branch');
Route::get('brands','App\Http\Controllers\API\ProductController@brands');
Route::get('single_product/{id}','App\Http\Controllers\API\ProductController@single_product');

Route::get('branches','App\Http\Controllers\API\BranchesController@branches');
Route::get('areas/{id}','App\Http\Controllers\API\BranchesController@areas');
Route::get('city','App\Http\Controllers\API\BranchesController@city');
Route::get('brand_product/{id}','App\Http\Controllers\API\BranchesController@brand_product');

Route::get('edit_address/{id}','App\Http\Controllers\API\BranchesController@edit_address');
Route::get('delete_address/{id}','App\Http\Controllers\API\BranchesController@delete_address');

Route::post('priceRange','App\Http\Controllers\API\FilterController@priceRange');
Route::post('categoryBrand','App\Http\Controllers\API\FilterController@categoryBrand');

Route::get('settings','App\Http\Controllers\API\SystemsettingController@settings');
Route::post('order_proceed','App\Http\Controllers\API\OrderController@order_proceed');

Route::get('order_history','App\Http\Controllers\API\OrderController@order_history');
Route::get('order_detail/{id}','App\Http\Controllers\API\OrderController@order_detail');
Route::post('prescription','App\Http\Controllers\API\OrderController@prescription');
Route::get('subscription','App\Http\Controllers\API\SystemsettingController@subscription');

Route::get('prescrip/{id}','App\Http\Controllers\API\OrderController@prescrip');

Route::get('inventories_by_branch/{branch_id}','App\Http\Controllers\API\InventoryController@getInventoryByBranch');
Route::get('inventories_by_product_unit_branch/{product_id}/{unit_id}/{branch_id}','App\Http\Controllers\API\InventoryController@inventories_by_product_unit_branch');




Route::get('test','App\Http\Controllers\API\SystemsettingController@test');



Route::get('search/{id}',[FilterController::class,'search']);
Route::get('product_search/{id}',[FilterController::class,'product_search']);
Route::post('update_product_inventory',[FilterController::class,'update_product_inventory']);


Route::get('fetch-sales-with-items','App\Http\Controllers\API\ProductController@fetchSalesWithItems');
Route::get('fetch-inventory','App\Http\Controllers\API\ProductController@fetchInventory');
Route::get('fetch-miss-sale','App\Http\Controllers\API\ProductController@fetchMissSale');
Route::get('fetch-opening-balance','App\Http\Controllers\API\ProductController@fetchOpeningBalance');
Route::get('fetch-customers','App\Http\Controllers\API\ProductController@fetchCustomers');
Route::get('fetch-return-sales','App\Http\Controllers\API\ProductController@fetchReturnSales');



Route::get('send-branches-data','App\Http\Controllers\API\ProductController@sendBranchesData');
Route::get('send-supplier-data','App\Http\Controllers\API\ProductController@sendSupplierData');

// send products to branch
Route::get('send-product-data','App\Http\Controllers\API\ProductController@sendProductData');

Route::get('send-categories-data','App\Http\Controllers\API\ProductController@sendCategoriesData');
Route::get('send-sub-categories-data','App\Http\Controllers\API\ProductController@sendSubCategoriesData');
Route::get('send-brands-data','App\Http\Controllers\API\ProductController@sendBrandsData');
Route::get('send-unit-data','App\Http\Controllers\API\ProductController@sendUnitData');
Route::get('send-product_unit_status-data','App\Http\Controllers\API\ProductController@sendProductUnitStatusData');
//Route::get('send-purchase-data','App\Http\Controllers\API\ProductController@sendPurchaseData');
//Route::get('send-purchase_detail-data','App\Http\Controllers\API\ProductController@sendPurchaseDetailData');
Route::get('send-role-data','App\Http\Controllers\API\ProductController@sendRoleData');
Route::get('send-permission-data','App\Http\Controllers\API\ProductController@sendPermissionData');
Route::get('send-role-permission-data','App\Http\Controllers\API\ProductController@sendRolePermissionData');
Route::get('send-advertisement-data','App\Http\Controllers\API\ProductController@sendAdvertisementData');
Route::get('send-cities-data','App\Http\Controllers\API\ProductController@sendCitiesData');
Route::get('send-areas-data','App\Http\Controllers\API\ProductController@sendAreasData');

