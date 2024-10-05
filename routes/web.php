<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth:api', 'role:Trainer')->get('trainer/classes', [TrainerController::class, 'viewClasses']);
Route::middleware('auth:api', 'role:Trainee')->group(function () {
    Route::get('trainee/bookings', [BookingController::class, 'index']);
    Route::post('trainee/bookings', [BookingController::class, 'store']);
    Route::delete('trainee/bookings/{id}', [BookingController::class, 'destroy']);
});



Route::middleware('auth:api', 'role:Admin')->group(function () {
    Route::apiResource('admin/trainers', TrainerController::class);
    Route::apiResource('admin/classes', ClassController::class);
});


Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index'); // সকল ইউজার দেখার জন্য
    Route::post('users', [UserController::class, 'store'])->name('users.store'); // নতুন ইউজার তৈরি
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show'); // নির্দিষ্ট ইউজার দেখার জন্য
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update'); // ইউজার আপডেট করার জন্য
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // ইউজার মুছে ফেলার জন্য
});