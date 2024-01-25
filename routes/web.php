<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZarinpalController;
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

Route::get('/', [\App\Http\Controllers\MasterController::class, 'Index'])->name('Public > Home');

Route::get('guest/advertisement/add', [\App\Http\Controllers\MasterController::class, 'GuestAdvertisement'])->name('Public > Guest > AdAdvertisement');
Route::post('guest/submit_business', [\App\Http\Controllers\AdvertiserController::class, 'SubmitAdvertise'])->name('Public > Guest > Advertisement > Create');

Route::get('/search', [\App\Http\Controllers\MasterController::class, 'Search'])->name('Public > Search');
Route::get('/business/{advertisement}/{slug}', [\App\Http\Controllers\AdvertisementController::class, 'Show'])->name('Public > Advertisement > Show');
Route::post('/business/comment/{ad_id}', [\App\Http\Controllers\AdvertisementController::class, 'SubmitComment'])->name('Public > Advertisement > Comment');

Route::get('page/{slug}', [\App\Http\Controllers\PageController::class, 'Show'])->name('Public > Page > Single');


/**--------------------------  authentication  --------------------------*/
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'Login'])->name('Auth > Login');
    Route::any('/register', [AuthController::class, 'Register'])->name('Auth > Register');
    Route::any('/logout', [AuthController::class, 'Logout'])->name('Auth > Logout');
});

/**--------------------------  api  --------------------------*/
Route::prefix('api')->group(function () {

    // otp & phone validation group
    Route::any('/otp/generate', [AuthController::class, 'GenerateOtp'])->name('Api > Otp > Generate');
    Route::post('/otp/validate', [AuthController::class, 'ValidateOtp'])->name('Api > Otp > Validate');
    Route::post('/phone/validate', [AuthController::class, 'ValidatePhone'])->name('Api > Phone > Validate');

    Route::prefix('/public')->group(function () {
        Route::any('/list_cities', [\App\Http\Controllers\AdvertiserController::class, 'ListCities'])->name('Public > Api > List Cities');
        Route::any('/list_occupations', [\App\Http\Controllers\OccupationController::class, 'ListOccupations'])->name('Public > Api > List Occupations');
        Route::any('/submit_rating', [\App\Http\Controllers\AdvertiserController::class, 'SubmitRating'])->name('Public > Api > Submit Rating');
    });
});

/**--------------------------  Payment Gateways  --------------------------*/
Route::prefix('ipg')->group(function () {

    /**--------------------------  ZARINPAL  --------------------------*/
    Route::prefix('zarinpal')->group(function () {
        Route::get('/transaction/{id}/pay', [ZarinpalController::class, 'Pay'])->name('Zarinpal > Transaction > Pay');
        Route::get('/callback', [ZarinpalController::class, 'Callback'])->name('Zarinpal > Transaction > Callback');
        Route::get('/verify', [ZarinpalController::class, 'Verify'])->name('Zarinpal > Transaction > Verify');
    });

});


/**-------------------------- Advertiser group  --------------------------*/
Route::prefix('panel')->middleware(['HasAdvertiserAccess'])->group(function () {
    Route::get('/', [\App\Http\Controllers\AdvertiserController::class, 'Panel'])->name('Advertiser > Panel');
    Route::get('/add_business', [\App\Http\Controllers\AdvertiserController::class, 'AddAdvertise'])->name('Advertiser > Form');
    Route::post('/submit_business', [\App\Http\Controllers\AdvertiserController::class, 'SubmitAdvertise'])->name('Advertiser > Create');
    Route::any('/bind_package/{id}', [\App\Http\Controllers\AdvertiserController::class, 'BindPackageToAdvertise'])->name('Advertiser > Advertisement > Bind Package');
    Route::get('/business_pay/{id}/confirm', [\App\Http\Controllers\AdvertiserController::class, 'PayAdvertise'])->name('Advertiser > Advertisement > Pay Confirm');

    Route::match(['GET', 'POST'],'profile', [\App\Http\Controllers\AdvertiserController::class, 'ProfileManager'])->name('Advertiser > Profile');
});

/**-------------------------- Admin group  --------------------------*/
Route::prefix('dashboard')->middleware(['HasAdminAccess'])->group(function () {
    Route::get('/', [AdminController::class, 'Dashboard'])->name('Admin > Dashboard');

    Route::any('/advertisements/manage', [AdminController::class, 'AdsManager'])->name('Admin > Advertisements > Manage');
    Route::get('/advertisements/preview/{id}', [AdminController::class, 'AdsPreview'])->name('Admin > Advertisements > Preview');


    Route::any('/users/manage', [AdminController::class, 'UserManager'])->name('Admin > Users > Manage');
    Route::any('/user/edit/{user}', [AdminController::class, 'EditUser'])->name('Admin > Users > Edit');

    Route::any('/settings/manage', [AdminController::class, 'SettingsManager'])->name('Admin > Settings > Manage');
    Route::any('/settings/update', [AdminController::class, 'UpdateSettings'])->name('Admin > Settings > Update');

    Route::get('page/new', [\App\Http\Controllers\PageController::class, 'New'])->name('Admin > Page > New');
    Route::post('page/new/submit', [\App\Http\Controllers\PageController::class, 'Submit'])->name('Admin > Page > Submit');
    Route::get('page/manage/', [\App\Http\Controllers\PageController::class, 'Manage'])->name('Admin > Page > Manage');
    Route::get('page/edit/{id}', [\App\Http\Controllers\PageController::class, 'Edit'])->name('Admin > Page > Edit');
    Route::post('page/edit/{id}/update', [\App\Http\Controllers\PageController::class, 'Update'])->name('Admin > Page > Update');
    Route::post('page/delete/{id}', [\App\Http\Controllers\PageController::class, 'DeleteTemporary'])->name('Admin > Page > Delete');
    Route::post('page/permanenet-delete/{id}/', [\App\Http\Controllers\PageController::class, 'DeletePermanently'])->name('Admin > Page > Delete Permanently');
    Route::post('page/restore/{id}', [\App\Http\Controllers\PageController::class, 'Restore'])->name('Admin > Page > Restore');
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
require __DIR__.'/auth.php';


//Route::get('/lottery', [\App\Http\Controllers\TestController::class, 'AdsLevelLottery']);
//Route::get('/adsFaker', [\App\Http\Controllers\TestController::class, 'FakeAds']);
//Route::get('/commentsFaker', [\App\Http\Controllers\TestController::class, 'FakeComments']);
Route::get('/test', [\App\Http\Controllers\TestController::class, 'AdsCatgoryLottery']);
