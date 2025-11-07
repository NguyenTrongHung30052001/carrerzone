<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserTuyenDung;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class TuyenDungRegisterController extends Controller
{
    // Định nghĩa các lựa chọn cố định cho dropdowns
    protected $operation_types = [
        '100% vốn nước ngoài', 'Cá nhân', 'Công ty đa quốc gia', 'Cổ phần', 'Liên doanh', 'Nhà nước', 'Trách nhiệm hữu hạn'
    ];
    
    protected $employee_counts = [
        'Ít hơn 10', '10-20', '25-99', '100-499', '500-999', '1.000-4.999', '5.000-9.999', '10.000-19.999', '20.000-49.999', 'Hơn 50.000'
    ];

    /**
     * Hiển thị form đăng ký.
     */
    public function create()
    {
        $provinces = Province::where('trang_thai', 'enable')->orderBy('ten_tinh_thanh_pho')->get();
        
        return view('auth.tuyen-dung-register', [
            'provinces' => $provinces,
            'operation_types' => $this->operation_types,
            'employee_counts' => $this->employee_counts
        ]);
    }

    /**
     * Xử lý lưu thông tin đăng ký.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_cong_ty' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.UserTuyenDung::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'operation_type' => ['required', 'string', Rule::in($this->operation_types)],
            'total_employees' => ['required', 'string', Rule::in($this->employee_counts)],
            'province_id' => ['required', 'exists:provinces,id'],
            'ward_id' => ['required', 'exists:wards,id'],
            'address' => ['required', 'string', 'max:255'],
            'company_introduction' => ['required', 'string'],
            'contact_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'tax_code' => ['required', 'string', 'max:20', 'unique:'.UserTuyenDung::class],
        ]);

        $user = UserTuyenDung::create([
            'ten_cong_ty' => $request->ten_cong_ty,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'operation_type' => $request->operation_type,
            'total_employees' => $request->total_employees,
            'province_id' => $request->province_id,
            'ward_id' => $request->ward_id,
            'address' => $request->address,
            'company_introduction' => $request->company_introduction,
            'contact_name' => $request->contact_name,
            'phone' => $request->phone,
            'tax_code' => $request->tax_code,
        ]);

        // Đăng nhập nhà tuyển dụng mới
        Auth::guard('tuyen_dung')->login($user);

        // <<< ĐÃ CẬP NHẬT CHUYỂN HƯỚNG TẠI ĐÂY >>>
        return redirect(route('employers.dashboard'));
    }

    /**
     * API endpoint để lấy danh sách Phường/Xã dựa trên Tỉnh/Thành.
     */
    public function getWards(Province $province)
    {
        $wards = $province->wards()->where('trang_thai', 'enable')->orderBy('ten_xa_phuong')->get();
        return response()->json($wards);
    }
}