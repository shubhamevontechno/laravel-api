<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StepController;
use App\Http\Controllers\Web\StepFormController;
use App\Http\Controllers\DonationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('/', StepController::class);
Route::resource('step-form', StepFormController::class);
Route::get('/second-form/{id}', [StepFormController::class, 'second_form'])->name('second-form');
Route::get('/second-form-index/{id}', [StepFormController::class, 'second_form_index'])->name('second-form-index');
Route::get('/third-form-index/{id}', [StepFormController::class, 'third_form_index'])->name('third-form-index');
Route::post('/delete-image', [StepFormController::class, 'delete_image']);
Route::post('/upload', [StepFormController::class, 'upload'])->name('upload');
Route::post('/second-step-store',[StepFormController::class, 'store_second_form'])->name('second-step-store');
Route::post('/third-step-store',[StepFormController::class, 'store_third_form'])->name('third-step-store');
Route::get('/search', [StepController::class, 'search'])->name('search');
Route::resource('donation', DonationController::class);

