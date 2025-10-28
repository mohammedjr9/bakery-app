<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\user\UserController;

use App\Http\Controllers\ConstantController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\FoodPackageController;
use App\Http\Controllers\UploadExcelController;
use App\Http\Controllers\ClothingPackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleBtnController;
use App\Http\Controllers\RolePageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StockMovementController;


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/submit', [LoginController::class, 'login'])->name('login.check');
// Route::group(['middleware' => [Authenticate::class]],function(){

Route::group(['middleware' => ['auth']], function () {
    Route::get('/test', function () {
        // dd(session('permission_btn'));

    })->name('test');
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::group(['prefix' => 'coupons', 'as' => 'coupon.'], function () {
        Route::post('/insert_food_package', [FoodPackageController::class, 'insert_food_package'])->name('insert_food_package');
        Route::get('/food_coupons', [FoodPackageController::class, 'food_coupons'])->name('food_coupons');
        Route::post('/getCouponsInfo', [FoodPackageController::class, 'getCouponsInfo'])->name('getCouponsInfo');

        Route::get('/', [BeneficiaryController::class, 'index'])->name('index');
        Route::get('/result_search', [BeneficiaryController::class, 'result_search'])->name('result_search')->withoutMiddleware('isAdmin');
        Route::post('/change_status', [BeneficiaryController::class, 'change_status'])->name('change_status')->withoutMiddleware('isAdmin');
        Route::post('/cancel_receipt', [BeneficiaryController::class, 'cancel_receipt'])->name('cancel_receipt');
        Route::get('/add_beneficiary', [BeneficiaryController::class, 'add_beneficiary'])->name('add_beneficiary');
        Route::get('/upload_bulk_excel', [UploadExcelController::class, 'index'])->name('upload_bulk_excel');
    });
    Route::group(['prefix' => 'clothing', 'as' => 'clothing.'], function () {
        Route::get('/', [ClothingPackageController::class, 'index'])->name('index');
        Route::get('/result_search', [ClothingPackageController::class, 'result_search'])->name('result_search');
        Route::post('/change_status', [ClothingPackageController::class, 'change_status'])->name('change_status');
        Route::get('/report', [ClothingPackageController::class, 'report'])->name('report');
        Route::get('/report-ajax', [ClothingPackageController::class, 'report_ajax'])->name('report_ajax');
        Route::get('/upload_clothing_excel', [UploadExcelController::class, 'uploadClothing'])->name('upload_clothing_excel');
        Route::post('/import_clothing_excel', [UploadExcelController::class, 'importClothing'])->name('import_clothing_excel');
        Route::get('/delivered-list', [ClothingPackageController::class, 'deliveredList'])->name('delivered_list');
        Route::get('/export-delivered', [ClothingPackageController::class, 'exportDelivered'])->name('export_delivered');
        Route::get('/last_update', [ClothingPackageController::class, 'last_update'])->name('last_update');
    });
    Route::group(['prefix' => 'constants', 'as' => 'constants.'], function () {
        Route::get('/', [ConstantController::class, 'index'])->name('index');
        Route::get('/create', [ConstantController::class, 'create'])->name('create');
        Route::post('/', [ConstantController::class, 'store'])->name('store');
        Route::get('/{constant}/edit', [ConstantController::class, 'edit'])->name('edit');
        Route::put('/{constant}', [ConstantController::class, 'update'])->name('update');
        Route::delete('/{constant}', [ConstantController::class, 'destroy'])->name('destroy');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/insert', [BeneficiaryController::class, 'insert'])->name('insert');
    Route::get('export', [BeneficiaryController::class, 'export']);


    Route::post('/import-excel', [UploadExcelController::class, 'importExcel'])->name('import_excel');
    Route::post('/save_beneficiary_info', [BeneficiaryController::class, 'save_beneficiary_info'])->name('save_beneficiary_info');


    // Route::get('/test', function () {
    //     dd(Beneficiary::select('code_num', 'name', 'id_num', 'created_at')->withCount('receipts_chech')->first());
    // });

    Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/insert_user', [UserController::class, 'insert_user'])->name('insert_user');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/update_password', [UserController::class, 'update_password'])->name('update_password');
    });

    Route::group(['prefix' => 'role_page', 'as' => 'role_page.'], function () {
        Route::get('/', [RolePageController::class, 'index'])->name('index');
        Route::post('/insert_role_page', [RolePageController::class, 'insert_role_page'])->name('insert_role_page');
        Route::post('/update_role_page', [RolePageController::class, 'update_role_page'])->name('update_role_page');
    });

    Route::group(['prefix' => 'role_btn', 'as' => 'role_btn.'], function () {
        Route::get('/', [RoleBtnController::class, 'index'])->name('index');
        Route::post('/insert_role_btn', [RoleBtnController::class, 'insert_role_btn'])->name('insert_role_btn');
        Route::post('/update_role_btn', [RoleBtnController::class, 'update_role_btn'])->name('update_role_btn');
    });

    Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/user-permissions', [PermissionController::class, 'userPermissions'])->name('user.permissions');
        Route::post('/toggle_role_page', [PermissionController::class, 'toggle_role_page'])->name('toggle_role_page');
        Route::post('/toggle_role_btn', [PermissionController::class, 'toggle_role_btn'])->name('toggle_role_btn');
    });
    Route::get('/search-suggestions', [SearchController::class, 'suggestions'])->name('user.search');

    Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');

    Route::get('/warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
    Route::post('/warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');
    Route::get('/warehouses/{id}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
    Route::put('/warehouses/{id}', [WarehouseController::class, 'update'])->name('warehouses.update');
    Route::delete('/warehouses/{id}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');
    Route::post('/deliver-package/{id}', [App\Http\Controllers\BeneficiaryController::class, 'deliverPackage']);
    Route::get('/stock-out', [StockMovementController::class, 'create'])->name('stock.out.form');
    Route::post('/stock-out', [StockMovementController::class, 'store'])->name('stock.out.store');

    Route::resource('warehouses', WarehouseController::class);
    Route::get('/warehouses/{warehouse}/stock/add', [StockMovementController::class, 'create'])->name('warehouse.stock.add');
    Route::post('/stock-movements/store', [StockMovementController::class, 'store'])->name('stock_movements.store');
    Route::get('/stock_movements/{stock_movement}', [StockMovementController::class, 'show'])->name('stock_movements.show');

    Route::get('/warehouses/{warehouse}/stock/deliver', [StockMovementController::class, 'createDeliver'])->name('warehouse.stock.deliver');
    Route::post('/warehouses/{warehouse}/stock/deliver', [StockMovementController::class, 'storeDeliver'])->name('warehouse.stock.deliver.store');


    Route::delete('/stock_movements/{id}', [StockMovementController::class, 'destroy'])->name('stock_movements.destroy');
    Route::get('/warehouses/{warehouse}/stock/filter', [StockMovementController::class, 'filter'])->name('warehouse.stock.filter');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout')
        ->withoutMiddleware('isAdmin');
});



