<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DesignsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\QuantityUnitsController;
use App\Http\Controllers\reminderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;

// Disable CSRF validation for these routes
Route::withoutMiddleware([VerifyCsrfToken::class])->group(function () {
   
Route::middleware('auth')->group(function () {
    
    Route::get('/', function () { 
        $role = Auth::user()->role;
        if($role == "admin"){
            return Redirect("/admin");
        }else{
            return Redirect("/manager");
        }
     })->name('index');

    // Routes for admin
    Route::prefix('admin')->middleware(\App\Http\Middleware\RoleAdminMiddleware::class)->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', "index")->name('admin.index');

            // Users
            Route::get('/add-user', "add_user")->name('admin.add-user');
            Route::post('/add-user', "user_store")->name('admin.add-user.store');

            // Quantity Units
            Route::get('/quantity-units', "QuantityUnits")->name('admin.quantity-units');
            Route::get('/quantity-units/new', "QuantityUnitsAdd")->name('admin.quantity-units.add');
            Route::get('/quantity-units/{encodedId}/edit', "QuantityUnitsEdit")->name('admin.quantity-units.edit');

            // Product
            // Route::get('/new/product', "newProduct")->name('admin.new.product');
            // Route::get('/list/product', "listProduct")->name('admin.list.product');
            // Route::get('/view/{encodedId}/product', "viewProduct")->name('admin.view.product');
            // Route::get('/edit/{encodedId}/product', "editProduct")->name('admin.edit.product');

            // Reminder
            Route::get('/reminder', "reminder")->name('admin.reminder');
            Route::get('/reminder/list', "reminder_list")->name('admin.reminder.list');
            Route::get('/reminder/{encodedId}/view', "reminder_view")->name('admin.reminder.view');
            Route::get('/reminder/{encodedId}/edit', "reminder_edit")->name('admin.reminder.edit');

            // Order
            Route::get('/new/order', "newOrder")->name('admin.new.order');
            Route::get('/list/order', "listOrder")->name('admin.list.order');
            Route::get('/view/{encodedId}/order', "viewOrder")->name('admin.view.order');
            Route::get('/edit/{encodedId}/order', "editOrder")->name('admin.edit.order');
            Route::get('/invoice', "invoiceShow")->name('admin.invoice');

            // Design
            Route::get('/gallery', "Gallery")->name('admin.gallery');
            Route::get('/new/design', "newDesign")->name('admin.new.design');
            Route::get('/list/design', "listDesign")->name('admin.list.design');
            Route::get('/view/{encodedId}/design', "viewDesign")->name('admin.view.design');
            Route::get('/edit/{encodedId}/design', "editDesign")->name('admin.edit.design');

            // Report
            Route::get('/report', "Report")->name('admin.report');
            Route::get('/export', [ReportController::class, 'export'])->name('admin.download.report');
            Route::get('/getReportByFilter', [ReportController::class, 'getReportByFilter'])->name('getReportByFilter');
        });

        
        Route::controller(CustomerController::class)->group(function(){
            Route::get('/customer/add', "admin_add")->name('admin.customer.add');
            Route::get('/customer/list', "admin_list")->name('admin.customer.list');
            Route::get('/customer/{encodedId}/view', "admin_view")->name('admin.customer.view');
            Route::get('/customer/list/all', "admin_list_all")->name('admin.customer.list-all');
            Route::get('/customer/overall/{encodedId}/view/', "admin_view_all")->name('admin.customer.all.view');
            Route::get('/customer/{encodedId}/edit', "admin_edit")->name('admin.customer.edit');
        });
        
    });

    // Routes for Manager
    Route::prefix('manager')->middleware(\App\Http\Middleware\RoleManagerMiddleware::class)->group(function () {
        Route::controller(ManagerController::class)->group(function () {
            Route::get('/', "index")->name('manager.index');
            Route::get('/profile', "profile")->name('manager.profile');


            // Reminder
            Route::get('/reminder', "reminder")->name('manager.reminder');
            Route::get('/reminder/list', "reminder_list")->name('manager.reminder.list');
            Route::get('/reminder/{encodedId}/view', "reminder_view")->name('manager.reminder.view');
            Route::get('/reminder/{encodedId}/edit', "reminder_edit")->name('manager.reminder.edit');

        });

        Route::controller(CustomerController::class)->group(function(){
            Route::get('/customer/add', "add")->name('manager.customer.add');
            Route::get('/customer/list', "list")->name('manager.customer.list');
            Route::get('/customer/{encodedId}/view', "view")->name('manager.customer.view');
            Route::get('/customer/{encodedId}/edit', "edit")->name('manager.customer.edit');
        });
    });

    // Routes for common Admin and Manager
    Route::controller(CustomerController::class)->group(function(){
        Route::post('/add-customer', "store")->name('customer.store');
        Route::post('/customer/{encodedId}/update', "update")->name('customer.update');
        Route::post('/add-customer', "store")->name('customer.store');
        Route::delete('/customer/{encodedId}/destroy', "destroy")->name('customer.destroy');
    });

    Route::controller(QuantityUnitsController::class)->group(function () {
        Route::post('/quantity-units/store', "store")->name('quantity-units.store');
        Route::post('/quantity-units/{encodedId}/update', "update")->name('quantity-units.update');
        Route::delete('/quantity-units/{encodedId}/destroy', "destroy")->name('quantity-units.destroy');
    });

    Route::controller(ProductsController::class)->group(function () {
        Route::post('/product/store', "store")->name('product.store');
        Route::post('/product/{encodedId}/update', "update")->name('product.update');
        Route::delete('/product/{encodedId}/destroy', "destroy")->name('product.destroy');
    });

    Route::controller(ScheduleController::class)->group(function () {
        Route::post('/schedule/store', "store")->name('schedule.store');
        Route::post('/schedule/{id}/update', "update")->name('schedule.update');
    });

    Route::controller(reminderController::class)->group(function () {
        Route::post('/reminder/store', "store")->name('reminder.store');
        Route::post('/reminder/{encodedId}/update', "update")->name('reminder.update');
        Route::delete('/reminder/{encodedId}/destroy', "destroy")->name('reminder.destroy');
        Route::post('/reminder/is_completed', "is_completed")->name('reminder.is_completed');
    });

    Route::controller(DesignsController::class)->group(function () {
        Route::post('/design/store', "store")->name('design.store');
        Route::post('/design/{encodedId}/update', "update")->name('design.update');
        Route::delete('/design/{encodedId}/destroy', "destroy")->name('design.destroy');
    });

    Route::controller(OrdersController::class)->group(function () {
        Route::post('/order/store', "store")->name('order.store');
        Route::post('/order/{encodedId}/update', "update")->name('order.update');
        Route::delete('/order/{encodedId}/destroy', "destroy")->name('order.destroy');
    });

    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/{encodeID}/download', "invoiceDownload")->name('admin.invoice.download');
        Route::get('/vendor/invoice/{encodeID}/download', "vendorInvoiceDownload")->name('admin.vendor.invoice.download');
    });
    
    Route::prefix('/api')->group( function () {
        Route::controller(ApisController::class)->group(function () {
            Route::get('/search/{encodedUserID}/{name}/{searchTerm}', "Search")->name('api.search');
            Route::get('/{action}/{encodedUserID}/{name}/{searchTerm}', "index")->name('api.index');
        });
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes for guest users
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        // Route::post('/login', 'showLoginForm')->name('login.post');
        Route::post('/login', 'loginPost')->name('login.post');
    });

});
});

Route::get('/run', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Working successfully',
    ]);
});


Route::get('/runcmd', function (Request $request) {
    try {
        Artisan::call('cache:clear');
        $cache = Artisan::output();

        Artisan::call('config:clear');
        $config = Artisan::output();

        Artisan::call('route:cache');
        $route = Artisan::output();

        Artisan::call('view:clear');
        $view = Artisan::output();

        \Log::info('Cache, config, and view caches cleared successfully.');

        Log::create([
            'message' => 'Cache, config, and view caches cleared successfully. Cache: ' . $cache . ', Config: ' . $config . ', View: ' . $view,
            'level' => 'info',
            'type' => 'runcmd',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cache, config, and view caches cleared successfully',
            'cache' => $cache,
            'config' => $config,
            'route' => $route,
            'view' => $view,
        ]);
    } catch (\Exception $e) {
        \Log::error('Error clearing cache: ' . $e->getMessage());

        Log::create([
            'message' => 'Failed to clear cache: ' . $e->getMessage(),
            'level' => 'error',
            'type' => 'runcmd',
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to clear cache',
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/test-session', function () {
    // Put a value in the session
    phpinfo();

});
