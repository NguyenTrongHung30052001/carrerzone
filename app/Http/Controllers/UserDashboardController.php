<?php

namespace App\Http\Controllers;

use App\Models\UserTuyenDung; // Import Model Nhà Tuyển Dụng
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * Hiển thị trang Dashboard chính cho ứng viên.
     */
    public function index(): View
    {
        // Lấy danh sách các Nhà Tuyển Dụng (tối đa 8) để hiển thị trong gallery
        $topEmployers = UserTuyenDung::select('ten_cong_ty', 'logo')
                                    ->inRandomOrder() // Hiển thị ngẫu nhiên
                                    ->take(6)       // Chỉ lấy 8 bản ghi
                                    ->get();

        // Gửi biến $topEmployers đến view
        return view('dashboard', compact('topEmployers'));
    }

    /**
     * (MỚI) Hiển thị trang danh sách TẤT CẢ công ty.
     */
    public function allCompanies(): View
    {
        // Lấy tất cả công ty, có phân trang (ví dụ: 20 công ty mỗi trang)
        // Chúng ta cũng tải kèm 'province' (Tỉnh/Thành) để hiển thị địa chỉ
        $allEmployers = UserTuyenDung::select('ten_cong_ty', 'logo', 'company_introduction', 'province_id')
                                    ->with('province') // Tải relationship 'province'
                                    ->orderBy('ten_cong_ty')
                                    ->paginate(20);

        return view('companies.index', compact('allEmployers'));
    }
}