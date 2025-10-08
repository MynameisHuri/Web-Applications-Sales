<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\DashboardController;

// Index Page
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Item Maintenance Page 
    Route::get('/ItemMaintenancePage', [ItemController::class, 'index'])->name('item.maintenance');
    Route::post('/ItemMaintenancePage', [ItemController::class, 'store'])->name('items.store');
    Route::put('/ItemMaintenancePage/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/ItemMaintenancePage/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

// Inventory Page 
    Route::get('/InventoryPage', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/InventoryPage', [InventoryController::class, 'store'])->name('inventory.store');

// Sales Page 
    Route::get('/SalesPage', [SalesController::class, 'index'])->name('sales.index');
    Route::post('/SalesPage', [SalesController::class, 'store'])->name('sales.store');

// Sales Report Page
    Route::get('/SalesReportPage', [SalesReportController::class, 'index'])->name('sales.report');
    Route::get('/SalesReportPage/data', [SalesReportController::class, 'getSalesData'])->name('sales.report.data');