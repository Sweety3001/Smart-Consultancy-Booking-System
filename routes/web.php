<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'consultant') {
            return redirect()->route('consultant.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }
    return redirect('/');
})->name('home');

Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['role.admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{id}/block', [AdminController::class, 'blockUser'])->name('users.block');
        Route::get('/consultants', [AdminController::class, 'consultants'])->name('consultants');
        Route::get('/consultants/create', [AdminController::class, 'createConsultant'])->name('consultants.create');
        Route::post('/consultants', [AdminController::class, 'storeConsultant'])->name('consultants.store');
        Route::delete('/consultants/{id}', [AdminController::class, 'destroyConsultant'])->name('consultants.destroy');
        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    });

    // Consultant Routes
    Route::middleware(['role.consultant'])->prefix('consultant')->name('consultant.')->group(function () {
        Route::get('/dashboard', [ConsultantController::class, 'dashboard'])->name('dashboard');
        Route::resource('services', ServiceController::class);
        Route::resource('availability', AvailabilityController::class);
        Route::get('/bookings', [BookingController::class, 'consultantIndex'])->name('bookings.index');
        Route::post('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
        Route::get('/earnings', [ConsultantController::class, 'earnings'])->name('earnings');
        Route::get('/profile', [ProfileController::class, 'consultantProfile'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'updateConsultantProfile'])->name('profile.update');
    });

    // Customer Routes
    Route::middleware(['role.customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/consultants', [CustomerController::class, 'consultants'])->name('consultants');
        Route::get('/bookings', [BookingController::class, 'customerIndex'])->name('bookings.index');
        Route::get('/bookings/create/{consultant_id}', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
        Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        
        // Payments
        Route::get('/payments/checkout/{booking_id}', [PaymentController::class, 'checkout'])->name('payments.checkout');
        Route::post('/payments/process', [PaymentController::class, 'process'])->name('payments.process');
        
        Route::get('/profile', [ProfileController::class, 'customerProfile'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'updateCustomerProfile'])->name('profile.update');
    });
});
