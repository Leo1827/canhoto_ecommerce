<?php
// admin
use App\Http\Controllers\Admin\AdminController;

// public
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;

// users
use App\Http\Controllers\User\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->get('/planes', [PlanController::class, 'index'])->name('plan.index');

require __DIR__.'/auth.php';
// User
Route::middleware(['auth', 'verified', 'userMiddleware', 'hasPlan'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// admin routes
Route::middleware(['auth','adminMiddleware'])->group(function(){

    Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');


});