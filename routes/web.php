<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\TuyenDungLoginController;
use App\Http\Controllers\Auth\TuyenDungRegisterController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\BenefitController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\WardController;
use App\Http\Controllers\Admin\ProfessionController;
use App\Http\Controllers\Employers\PostController;
use App\Http\Controllers\Employers\EmployerProfileController; // <-- ĐÃ THÊM
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === ỨNG VIÊN (USER_UNG_VIEN) ===

// Rule 1: Trang chủ (/) vào /dashboard (công khai)
Route::get('/', function () {
    return redirect('/dashboard');
});

// Rule 1: Trang /dashboard (công khai)
Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

// Trang /cong-ty (công khai)
Route::get('cong-ty', [UserDashboardController::class, 'allCompanies'])->name('companies.index');

// Các route xác thực của 'web' (login, register, v.v...)
require __DIR__.'/auth.php';

// Các trang được bảo vệ của 'web' (ung_vien)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// === ADMIN (USER_ADMIN) ===

// Rule 3: Trang /admin được bảo vệ
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');

    // CRUDs
    Route::resource('benefits', BenefitController::class)->except(['show', 'destroy']);
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::resource('provinces', ProvinceController::class)->except(['index', 'show', 'destroy']);
    Route::resource('wards', WardController::class)->except(['index', 'show', 'destroy']);
    Route::resource('professions', ProfessionController::class)->except(['show', 'destroy']);
});

// Trang login admin (chỉ cho khách)
Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('login', [AdminLoginController::class, 'store']);
});


// === NHÀ TUYỂN DỤNG (USER_TUYEN_DUNG) ===

// Rule 2: Trang /employers (chuyển hướng)
Route::get('employers', function () {
    return redirect()->route('employers.dashboard');
})->name('employers.index');

// Rule 2: Trang /employers/dashboard (công khai)
Route::get('employers/dashboard', function () {
    // Nếu đã đăng nhập, hiển thị dashboard
    // if (Auth::guard('tuyen_dung')->check()) {
    //     return view('employers.dashboard');
    // }
    // // Nếu chưa, chuyển đến trang login
    // return redirect()->route('employers.login');

    return view('employers.dashboard');

})->name('employers.dashboard');


// Trang login/register nhà tuyển dụng (chỉ cho khách)
Route::prefix('employers')->name('employers.')->middleware('guest:tuyen_dung')->group(function () {
    Route::get('login', [TuyenDungLoginController::class, 'create'])->name('login');
    Route::post('login', [TuyenDungLoginController::class, 'store']);
    Route::get('register', [TuyenDungRegisterController::class, 'create'])->name('register');
    Route::post('register', [TuyenDungRegisterController::class, 'store']);
});

// Các trang được bảo vệ của 'tuyen_dung'
Route::prefix('employers')->name('employers.')->middleware('auth:tuyen_dung')->group(function () {
    Route::post('logout', [TuyenDungLoginController::class, 'destroy'])->name('logout');
    
    // CRUD Tin đăng
    Route::resource('posts', PostController::class);

    // (CÁC ROUTE MỚI CHO PROFILE ĐÃ ĐƯỢC THÊM VÀO ĐÂY)
    Route::get('profile', [EmployerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [EmployerProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/logo', [EmployerProfileController::class, 'updateLogo'])->name('profile.updateLogo');
    
});

// === API Routes (cho AJAX) ===
Route::get('/api/wards/{province}', [TuyenDungRegisterController::class, 'getWards']);