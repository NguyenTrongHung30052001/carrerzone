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
|
| File này điều hướng 3 luồng chính:
| 1. Ứng viên (guard: 'web')
| 2. Admin (guard: 'admin')
| 3. Nhà tuyển dụng (guard: 'tuyen_dung')
|
*/

// ===================================================================
// == PHÂN HỆ 1: ỨNG VIÊN (USER_UNG_VIEN) - GUARD 'web'
// ===================================================================

// Yêu cầu: Trang chủ (/) mặc định vào /dashboard (công khai)
Route::get('/', function () {
    return redirect('/dashboard');
});

// Trang /dashboard (công khai) - Sử dụng Controller mới
Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

// Trang danh sách TẤT CẢ công ty (công khai)
Route::get('cong-ty', [UserDashboardController::class, 'allCompanies'])->name('companies.index');

// Trang TÌM VIỆC LÀM (công khai)
Route::get('viec-lam-theo-nganh-nghe', [JobSearchController::class, 'index'])->name('jobs.index');


// Các route của Breeze (login, register, logout...)
// Được bảo vệ bởi 'guest' (khách) hoặc 'auth' (đã đăng nhập)
require __DIR__.'/auth.php';

// Các trang được bảo vệ của 'ung_vien' (phải đăng nhập 'web')
Route::middleware(['auth', 'verified'])->group(function () {
    // Route cho /profile (của ung_vien)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================================================================
// == PHÂN HỆ 2: ADMIN (USER_ADMIN) - GUARD 'admin'
// ===================================================================

// Nhóm này yêu cầu phải đăng nhập với guard 'admin'
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {

    // Trang /admin (dashboard)
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Xử lý đăng xuất Admin
    Route::post('logout', [AdminLoginController::class, 'destroy'])
                ->name('logout');

    // CRUD: Phúc lợi
    Route::resource('benefits', BenefitController::class)->except(['show', 'destroy']);
    
    // CRUD: Địa chỉ (Locations)
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::resource('provinces', ProvinceController::class)->except(['index', 'show', 'destroy']);
    Route::resource('wards', WardController::class)->except(['index', 'show', 'destroy']);
    
    // CRUD: Ngành nghề
    Route::resource('professions', ProfessionController::class)->except(['show', 'destroy']);

});

// Các route đăng nhập Admin (chỉ dành cho khách 'guest:admin')
Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])
                ->name('login');
    Route::post('login', [AdminLoginController::class, 'store']);
});


// ===================================================================
// == PHÂN HỆ 3: NHÀ TUYỂN DỤNG (USER_TUYEN_DUNG) - GUARD 'tuyen_dung'
// ===================================================================

// Yêu cầu: /employers là trang công khai, bỏ qua đăng nhập
Route::get('employers', function () {
    // Tự động chuyển hướng /employers -> /employers/dashboard
    return redirect()->route('employers.dashboard');
})->name('employers.index');

// Trang /employers/dashboard (công khai)
Route::get('employers/dashboard', function () {
    return view('employers.dashboard');
})->name('employers.dashboard');


// Nhóm đăng nhập/đăng ký (chỉ dành cho khách 'guest:tuyen_dung')
Route::prefix('employers')->name('employers.')->middleware('guest:tuyen_dung')->group(function () {
    // Trang đăng nhập
    Route::get('login', [TuyenDungLoginController::class, 'create'])
                ->name('login');
    Route::post('login', [TuyenDungLoginController::class, 'store']);
    
    // Trang đăng ký
    Route::get('register', [TuyenDungRegisterController::class, 'create'])
                ->name('register');
    Route::post('register', [TuyenDungRegisterController::class, 'store']);
});

// Nhóm các trang được bảo vệ của 'tuyen_dung' (phải đăng nhập 'tuyen_dung')
Route::prefix('employers')->name('employers.')->middleware('auth:tuyen_dung')->group(function () {
    
    // Xử lý đăng xuất
    Route::post('logout', [TuyenDungLoginController::class, 'destroy'])
                ->name('logout');

    // CRUD: Quản lý Tin đăng (Posts)
    Route::resource('posts', PostController::class)
         ->except(['show']); // Bỏ trang 'show'

    // Cập nhật Hồ sơ (Profile)
    Route::get('profile', [EmployerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [EmployerProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/logo', [EmployerProfileController::class, 'updateLogo'])->name('profile.updateLogo');
});


// ===================================================================
// == API (Dùng cho AJAX)
// ===================================================================
// API lấy danh sách Phường/Xã (dùng cho cả Ứng viên và Nhà Tuyển Dụng)
Route::get('/api/wards/{province}', [TuyenDungRegisterController::class, 'getWards']);