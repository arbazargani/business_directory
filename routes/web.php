<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});

/**--------------------------  authentication  --------------------------*/
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'Login'])->name('Auth > Login');
    Route::any('/register', [AuthController::class, 'Register'])->name('Auth > Register');
    Route::post('/logout', [AuthController::class, 'Logout'])->name('Auth > Logout');
});

/**--------------------------  api  --------------------------*/
Route::prefix('api')->group(function () {

    // otp & phone validation group
    Route::any('/otp/generate', [AuthController::class, 'GenerateOtp'])->name('Api > Otp > Generate');
    Route::post('/otp/validate', [AuthController::class, 'ValidateOtp'])->name('Api > Otp > Validate');
    Route::post('/phone/validate', [AuthController::class, 'ValidatePhone'])->name('Api > Phone > Validate');
});


/**-------------------------- Advertiser group  --------------------------*/
Route::prefix('panel')->middleware(['HasAdvertiserAccess'])->group(function () {
    Route::get('/', [\App\Http\Controllers\AdvertiserController::class, 'Panel'])->name('Advertiser > Panel');
    Route::post('/submit_business', [\App\Http\Controllers\AdvertiserController::class, 'addAdvertise'])->name('Advertiser > Create');
});

/**-------------------------- Advertiser group  --------------------------*/
Route::prefix('dashboard')->middleware(['HasAdminAccess'])->group(function () {
    Route::get('/', function () {
        return 'admin dashboard';
    })->name('Admin > Dashboard');
});

/**--------------------------  laravel basic authentication  --------------------------*/
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//require __DIR__.'/auth.php';
