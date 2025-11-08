<?php

// Import các Controller chung
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\JobSearchController;

// Import các Controller của Admin
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\BenefitController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\WardController;
use App\Http\Controllers\Admin\ProfessionController;

// Import các Controller của Nhà Tuyển Dụng
use App\Http\Controllers\Auth\TuyenDungLoginController;
use App\Http\Controllers\Auth\TuyenDungRegisterController;
use App\Http\Controllers\Employers\PostController;
use App\Http\Controllers\Employers\EmployerProfileController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===================================================================
// == PHÂN HỆ 1: ỨNG VIÊN (USER_UNG_VIEN) - GUARD 'web'
// ===================================================================

// Trang chủ (/) mặc định vào /dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Trang /dashboard (công khai)
Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

// Trang danh sách TẤT CẢ công ty (công khai)
Route::get('cong-ty', [UserDashboardController::class, 'allCompanies'])->name('companies.index');

// Trang TÌM VIỆC LÀM theo ngành nghề (công khai)
Route::get('viec-lam-theo-nganh-nghe', [JobSearchController::class, 'index'])->name('jobs.index');

// Trang DANH SÁCH VIỆC LÀM theo ngành nghề cụ thể (dùng slug)
Route::get('viec-lam/{slug}', [JobSearchController::class, 'showByProfession'])
     ->name('jobs.showByProfession');

// [QUAN TRỌNG] Trang CHI TIẾT VIỆC LÀM (Link từ card việc làm)
Route::get('tim-viec-lam/{slug}.{id}.html', [JobSearchController::class, 'show'])->name('jobs.show');


// Các route của Breeze (login, register, logout...)
require __DIR__.'/auth.php';

// Các trang được bảo vệ của 'ung_vien'
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================================================================
// == PHÂN HỆ 2: ADMIN (USER_ADMIN) - GUARD 'admin'
// ===================================================================

// Nhóm được bảo vệ (cần đăng nhập admin)
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');

    // Resources
    Route::resource('benefits', BenefitController::class)->except(['show', 'destroy']);
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::resource('provinces', ProvinceController::class)->except(['index', 'show', 'destroy']);
    Route::resource('wards', WardController::class)->except(['index', 'show', 'destroy']);
    Route::resource('professions', ProfessionController::class)->except(['show', 'destroy']);
});

// Nhóm khách (chưa đăng nhập admin)
Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('login', [AdminLoginController::class, 'store']);
});

// ===================================================================
// == PHÂN HỆ 3: NHÀ TUYỂN DỤNG (USER_TUYEN_DUNG) - GUARD 'tuyen_dung'
// ===================================================================

// Trang chủ employers -> chuyển hướng vào dashboard
Route::get('employers', function () {
    return redirect()->route('employers.dashboard');
})->name('employers.index');

// Dashboard (công khai theo yêu cầu)
Route::get('employers/dashboard', function () {
    return view('employers.dashboard');
})->name('employers.dashboard');

// Nhóm khách (chưa đăng nhập)
Route::prefix('employers')->name('employers.')->middleware('guest:tuyen_dung')->group(function () {
    Route::get('login', [TuyenDungLoginController::class, 'create'])->name('login');
    Route::post('login', [TuyenDungLoginController::class, 'store']);
    Route::get('register', [TuyenDungRegisterController::class, 'create'])->name('register');
    Route::post('register', [TuyenDungRegisterController::class, 'store']);
});

// Nhóm được bảo vệ (cần đăng nhập tuyen_dung)
Route::prefix('employers')->name('employers.')->middleware('auth:tuyen_dung')->group(function () {
    Route::post('logout', [TuyenDungLoginController::class, 'destroy'])->name('logout');
    
    Route::resource('posts', PostController::class)->except(['show']);
    
    Route::get('profile', [EmployerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [EmployerProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/logo', [EmployerProfileController::class, 'updateLogo'])->name('profile.updateLogo');
});

// ===================================================================
// == API (AJAX)
// ===================================================================
Route::get('/api/wards/{province}', [TuyenDungRegisterController::class, 'getWards']);