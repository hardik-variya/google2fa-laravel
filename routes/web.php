<?php

use App\Http\Controllers\Google2faController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('2fa');

Route::get('/generate2fa/secret', [Google2faController::class,'generate2faSecret'])->name('generate2fa.secret');
Route::post('/enable2fa', [Google2faController::class,'enable2fa'])->name('enable2fa');
Route::post('/disable2fa', [Google2faController::class,'disable2fa'])->name('disable2fa');

Route::post('/2faVerify', function () {
    return redirect(request()->get('2fa_referrer'));
})->name('2faVerify')->middleware('2fa');
