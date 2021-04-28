<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TierListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\auth\RegisterController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::get('/newtemplate', [TemplateController::class, 'index'])->name('newtemplate');
Route::post('/newtemplate', [TemplateController::class, 'store']);

Route::get('/templates/{template:id}', [TierListController::class, 'index'])->name('template');

Route::post('/tierlist/{template:id}', [TierListController::class, 'update'])->name('savetierlist');

Route::get('/test', [TestController::class, 'index'])->name('test');
Route::post('/test', [TestController::class, 'post']);


Route::get('/', function () {
    return view('home');
})->name('home');
