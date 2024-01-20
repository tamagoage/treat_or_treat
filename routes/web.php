<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreatController;

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

// 以下三つのRouteは、LaravelのデフォルトのRoute
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// testにアクセスしたら、resources/views/test.blade.phpを表示する
Route::get('/test', function () {
    return view('test');
});

// treatsにアクセス時の処理
Route::get('/treats', [TreatController::class, 'index'])->middleware('auth');

// treats/createにアクセス時の処理
Route::get('/treats/create', [TreatController::class, 'create'])->name('treats.create')->middleware('auth');

// treatsにPOSTリクエストが来た時の処理
Route::post('/treats.create', [TreatController::class, 'store'])->name('treats.store')->middleware('auth');

// treats/{treat}にアクセス時の処理
Route::get('/treats/{treat}', [TreatController::class, 'show'])->name('treats.show');

require __DIR__ . '/auth.php';
