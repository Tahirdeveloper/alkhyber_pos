<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportConrtoller;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/admin');
});

Auth::routes();

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::resource('products', ProductController::class);
    Route::get('/getproduct', [ProductController::class,'getproduct'])->name('product.getproduct');
    Route::get('product/delete/{id}', [ProductController::class,'destroy'])->name('product.delete');
// Purchase Controller
    Route::resource('purchase', PurchaseController::class);
    Route::get('quick/purchase', [PurchaseController::class,'quickPurchase'])->name('purchase.quickPurchase');
    Route::post('products/purchase', [PurchaseController::class,'storePurchase'])->name('purchase.storePurchase');
    Route::get('purchase/edit/{id}', [PurchaseController::class,'edit'])->name('purchase.edit');
    Route::put('update/purchase/{id}', [PurchaseController::class,'update'])->name('purchase.update');
    Route::post('updatePurchase', [PurchaseController::class,'updatePayment']);
    Route::post('refundPurchase', [PurchaseController::class,'refundPayment']);
    Route::delete('purchase/delete/{id}', [PurchaseController::class,'destroy'])->name('purchase.delete');
    Route::get('purchase/invoice/{id}', [PurchaseController::class,'showInvoice'])->name('purchase.invoice');
// Expensed Controller
    Route::get('expenses', [ExpenseController::class,'index'])->name('expense.index');
    Route::get('expense/create', [ExpenseController::class,'create'])->name('expense.create');
    Route::post('expense/store', [ExpenseController::class,'store'])->name('expense.store');
    Route::get('expense/edit/{id}', [ExpenseController::class,'edit'])->name('expense.edit');
    Route::put('update/expense/{id}', [ExpenseController::class,'update'])->name('expense.update');
    Route::delete('expense/delete/{id}', [ExpenseController::class,'destroy'])->name('expense.destroy');
// customer Controller
    Route::resource('add/customers', CustomerController::class);
    Route::resource('add/supplier', SupplierController::class);
    Route::get('manage/suppliers', [SupplierController::class,'index'])->name('viewSuppliers');
    Route::get('edit/{id}/supplier', [SupplierController::class,'edit'])->name('editSupplier');
    Route::put('update/{id}/supplier', [SupplierController::class,'update'])->name('updateSupplier');
    Route::get('create/supplier', [SupplierController::class,'create'])->name('createSupplier');
    Route::post('delete/{id}/supplier', [SupplierController::class,'destroy'])->name('deleteSupplier');

    Route::resource('orders', OrderController::class);
    Route::get('all/orders', [OrderController::class,'index'])->name('order.index');
    Route::post('update-payment', [OrderController::class,'updatePayment'])->name('orders.updatePayment');
    Route::post('refund-payment', [OrderController::class,'refundPayment'])->name('orders.refundPayment');
    Route::get('order/delete/{id}', [OrderController::class, 'deleteOrder'])->name('orders.delete');

    Route::get('/order/invoice/{c_id}', [OrderController::class, 'showInvoice'])->name('orderInvoice');

    // Report section
    Route::get('sales/report', [ReportConrtoller::class,'index'])->name('report.index');
    Route::get('expenses/report', [ReportConrtoller::class,'expenses'])->name('report.expenses');
    Route::get('reports/profit&loss', [ReportConrtoller::class,'profitLoss'])->name('report.profitLoss');

    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);

    Route::get('add/categories', [OptionController::class, 'show'])->name('categories.add');
    Route::get('manage/categories', [OptionController::class, 'manage'])->name('categories.manage');
    Route::get('category/edit/{id}', [OptionController::class, 'edit'])->name('categories.edit');
    // Insert Category
    Route::post('/categories', [OptionController::class, 'store'])->name('categories.store');
    // Update Category
    Route::put('/categories/{option}', [OptionController::class, 'update'])->name('category.update');
    // Delete Category
    Route::get('/category/{option}', [OptionController::class, 'destroy'])->name('category.destroy');
});