<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::redirect('/', '/login');
Route::get('/register', function () {
    return view('registeraccount'); })->name('register');


/* Admin account role */
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/* Client account role */
Route::middleware(['auth', 'checkrole:client'])->group(function () {
    Route::get('/home', function () {
        return view('livewire.home'); })->name('home');
    Route::get('/monthly-report', function () {
        return view('livewire.report'); })->name('monthly-report');
    Route::get('/quarterly-report', function () {
        return view('livewire.quarterly-report'); })->name('quarterly-report');
    Route::get('/admin-reports', function () {
        return view('livewire.admin-reports-index'); })->name('admin-reports');
});

