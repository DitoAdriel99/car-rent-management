    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\CarController;
    use App\Http\Controllers\CustomerController;
    use App\Http\Middleware\AdminMiddleware;
    use App\Http\Middleware\CustomerMiddleware;

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
        Route::post('/cars', [App\Http\Controllers\CarController::class, 'store'])->name('cars.store');
        Route::get('/adminOrders', [App\Http\Controllers\AdminController::class, 'order_waiting'])->name('admin.order.list');
        Route::get('/orders/{id}/profile', [App\Http\Controllers\AdminController::class, 'fetchProfile']);
        Route::get('/orders/{id}/accept', [App\Http\Controllers\AdminController::class, 'accept_order'])->name('orders.accept');
        Route::get('/orders/{id}/reject', [App\Http\Controllers\AdminController::class, 'reject_order'])->name('orders.reject');
        Route::get('/approve', [App\Http\Controllers\AdminController::class, 'order_ongoing'])->name('admin.order.approve.list');
        Route::get('/orders/{id}/complete', [App\Http\Controllers\AdminController::class, 'complete_order'])->name('orders.complete');
        Route::get('/history', [App\Http\Controllers\AdminController::class, 'history_order'])->name('admin.order.history');
        Route::put('/cars/{id}', [App\Http\Controllers\CarController::class, 'update'])->name('cars.update');
        Route::delete('/cars/{id}', [App\Http\Controllers\CarController::class, 'destroy'])->name('cars.delete');
    });

    Route::middleware(['auth', CustomerMiddleware::class])->group(function () {
        Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
        Route::post('/cars/{id}/order', [App\Http\Controllers\CarController::class, 'order'])->name('cars.order');
        Route::get('/orders', [App\Http\Controllers\CustomerController::class, 'order_list'])->name('customer.order.list');
        Route::get('/returning', [App\Http\Controllers\CustomerController::class, 'order_return'])->name('customer.order.list.return');
        Route::get('/orders/{id}/return', [App\Http\Controllers\CustomerController::class, 'return_order'])->name('orders.return');
        Route::get('/customerHistory', [App\Http\Controllers\CustomerController::class, 'history_order_cust'])->name('customer.order.list.history');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




