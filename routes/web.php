<?php

use App\Http\Controllers\GambarTenantController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTenantBookingController;
use App\Http\Controllers\TenantReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// ===== PUBLIC ROUTES (Tidak perlu login) =====

// Admin Login Routes
Route::get('/admin/login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');

// Logout Route
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Midtrans Payment
Route::post('/midtrans', [HomeController::class, 'midtrans'])->name('midtrans');

// ===== FORGOT PASSWORD ROUTES =====
// PENTING: Route ini harus SEBELUM middleware auth
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordPost'])->name('forgot.password.post');

// ===== PROTECTED ROUTES (Perlu login) =====
Route::middleware('auth')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');
    Route::get('/dashboard/chart', [DashboardController::class, 'getChartData'])->name('dashboard.chart');
    Route::get('/dashboard/export', [DashboardController::class, 'exportReport'])->name('dashboard.export');
    
    // User Management Routes
    Route::resource('user', UserController::class);
    Route::post('user/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
    
    // Tenant Management Routes
    Route::resource('tenant', TenantController::class);
    
    // Gambar Tenant Routes
    Route::resource('gambar_tenant', GambarTenantController::class);
    Route::post('tambah_gambar', [GambarTenantController::class, 'tambah_gambar'])->name('gambar_tenant.tambah_gambar');
    
    // Booking Management Routes
    Route::resource('user_tenant_boo', UserTenantBookingController::class);
    Route::resource('user_tenant_booking', UserTenantBookingController::class);
    Route::get('user_tenant_booking/scan', [UserTenantBookingController::class, 'scan'])->name('user_tenant_booking.scan');
    Route::post('user_tenant_booking/scan', [UserTenantBookingController::class, 'scanStore'])->name('user_tenant_booking.scanStore');
    
    // Report Routes
    Route::resource('tenant_report', TenantReportController::class);
});

// ===== PUBLIC FRONTEND ROUTES =====

// Home Pages
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/pariwisata', [HomeController::class, 'pariwisata'])->name('pariwisata');
Route::get('/tentang_kami', [HomeController::class, 'tentang_kami'])->name('tentang_kami');

// Booking Routes
Route::get('/booking', [HomeController::class, 'booking'])->name('booking');
Route::post('/booking', [HomeController::class, 'booking_post'])->name('booking_post');
Route::get('/tiket_qr_code', [HomeController::class, 'tiket_qr_code'])->name('tiket_qr_code');
Route::get('/riwayat_pemesanan', [HomeController::class, 'riwayat_pemesanan'])->name('riwayat_pemesanan');

// Pariwisata Detail
Route::get('/detail_pariwisata/{id}', [HomeController::class, 'detail_pariwisata'])->name('detail_pariwisata');

// Review/Ulasan Routes
Route::post('/ulasan', [HomeController::class, 'ulasan'])->name('ulasan');
Route::get('/ulasan/{id}/edit', [HomeController::class, 'editUlasan'])->name('ulasan.edit');
Route::put('/ulasan/{id}/update', [HomeController::class, 'updateUlasan'])->name('ulasan.update');
Route::delete('/ulasan/{id}/delete', [HomeController::class, 'deleteUlasan'])->name('ulasan.delete');

// Auth Pages untuk User
Route::get('/login', [HomeController::class, 'login'])->name('user.login');
Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_store'])->name('register.store');
Route::get('/forgot_password', [HomeController::class, 'forgot_password'])->name('forgot_password');

// Profile Routes
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::get('/edit_profile', [HomeController::class, 'edit_profile'])->name('edit_profile');