<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ReportController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


// Redirect from '/' to 'login'
Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Start Dari Sini 

Route::get('/main', function () {
    return view('main');
});

// Master Item
Route::resource('/items', ItemController::class)->names('items');

// Master UOM
Route::resource('/uoms', UomController::class)->names('uoms');

// Master Group
Route::resource('/groups', GroupController::class)->names('groups');

// Master Inventory
Route::resource('/inventory', InventoryController::class)->names('inventory');

// Sales
Route::resource('/sales', SalesController::class)->names('sales');

// Report
// Route::resource('/report', SalesController::class)->names('sales');
Route::get('/reports', [ReportController::class, 'reportSales'])->name('report.reportSales');














require __DIR__ . '/auth.php';


