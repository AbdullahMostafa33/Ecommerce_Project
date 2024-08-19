<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class, 'home'] )->name('home');

Route::get('/auth/redirect', [HomeController::class, 'redirectGoogle']);

Route::get('/callback',[HomeController::class, 'callbackGoogle']);


//user

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('profile', [UserController::class, 'profile'])->middleware('auth')->name('profile');

// Product routes
Route::get('/sections', [ProductController::class, 'showSections'])->name('products.sections');

Route::get('products/{section}', [ProductController::class, 'index'])->name('products.index');
Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('product/{id}/comment', [ProductController::class, 'storeComment'])->name('product.comment');
Route::post('comment/{comment}/update', [ProductController::class, 'updateComment'])->name('product.comment.update');

// Cart routes
Route::get('cart', [CartController::class, 'index'])->middleware('auth')->name('cart.index');
Route::post('cart/add/{product}', [CartController::class, 'add'])->middleware('auth')->name('cart.add');
Route::post('cart/remove/{item}', [CartController::class, 'remove'])->middleware('auth')->name('cart.remove');

// Order routes
Route::get('checkout/{order}', [OrderController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::get('order', [OrderController::class, 'placeOrder'])->middleware('auth')->name('order.place');
Route::get('orders', [OrderController::class, 'index'])->middleware('auth')->name('orders.index');
Route::get('order/invoice/{order}', [OrderController::class, 'showInvoice'])->name('invoice.show');
Route::get('order/cancel', [OrderController::class, 'cancel'])->middleware('auth')->name('order.cancel');


// Admin routes
Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Product management
    
    Route::get('/products', [AdminController::class, 'indexProduct'])->name('admin.products.index');

    Route::get('product/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('product/store', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('product/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('product/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('product/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.destroy');

    // Section management
    Route::get('/sections', [AdminController::class, 'indexSection'])->name('admin.sections.index');

    Route::get('section/create', [AdminController::class, 'createSection'])->name('admin.sections.create');
    Route::post('section/store', [AdminController::class, 'storeSection'])->name('admin.sections.store');
    Route::get('section/edit/{section}', [AdminController::class, 'editSection'])->name('admin.sections.edit');
    Route::put('section/update/{section}', [AdminController::class, 'updateSection'])->name('admin.sections.update');
    Route::delete('section/delete/{id}', [AdminController::class, 'deleteSection'])->name('admin.sections.destroy');

    // Order management
    Route::get('order', [AdminController::class, 'viewOrders'])->name('admin.orders.index');
    Route::get('order/{id}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::get('orders', [AdminController::class, 'viewOrders'])->name('admin.orders');
    Route::post('order/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::get('order/delete/{order}', [AdminController::class, 'deleteorder'])->name('admin.order.delete');


    //Notfication
    Route::get('notifications', [AdminController::class, 'showNotifications'])->name('showNotifications');
    Route::get('notifications/markAsRead/{id}/{order_id}', [AdminController::class, 'markAsRead'])->name('Notifications.markAsRead');
    Route::get('notifications/markAllAsRead', [AdminController::class, 'markAllAsRead'])->name('showNotifications.markAllAsRead');
    Route::get('notifications/deleteAll', [AdminController::class, 'deleteAllNotifications'])->name('showNotifications.deleteAll');

});
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

require __DIR__.'/auth.php';

