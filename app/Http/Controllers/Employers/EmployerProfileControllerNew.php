<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Province;
use App\Models\Benefit;
use App\Models\UserTuyenDung;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployerProfileControllerNew extends Controller
{
    // Các mảng dữ liệu cho dropdown (giống TuyenDungRegisterController)
    protected $operation_types = [
        '100% vốn nước ngoài', 'Cá nhân', 'Công ty đa quốc gia', 'Cổ phần', 'Liên doanh', 'Nhà nước', 'Trách nhiệm hữu hạn'
    ];
    protected $employee_counts = [
        'Ít hơn 10', '10-20', '25-99', '100-499', '500-999', '1.000-4.999', '5.000-9.999', '10.000-19.999', '20.000-49.999', 'Hơn 50.000'
    ];

    /**
     * Hiển thị form chỉnh sửa profile của nhà tuyển dụng.
     */
    public function edit(Request $request)
    {
        // Lấy nhà tuyển dụng đã đăng nhập
        $employer = Auth::guard('tuyen_dung')->user();

        // Tải trước các mối quan hệ để tối ưu
        $employer->load('benefits', 'province', 'ward');

        // Lấy dữ liệu cho các dropdown
        $provinces = Province::where('trang_thai', 'enable')->orderBy('ten_tinh_thanh_pho')->get();
        $benefits = Benefit::where('trang_thai', 'enable')->orderBy('ten_phuc_loi')->get();
        
        // Lấy các mảng lựa chọn
        $operation_types = $this->operation_types;
        $employee_counts = $this->employee_counts;

        // Lấy danh sách ID các phúc lợi mà nhà tuyển dụng này đã chọn
        $selectedBenefits = $employer->benefits->pluck('id')->toArray();

        return view('employers.profile.edit', compact(
            'employer', 
            'provinces', 
            'benefits', 
            'operation_types', 
            'employee_counts',
            'selectedBenefits'
        ));
    }

    /**
     * Cập nhật profile của nhà tuyển dụng.
     */
    public function update(Request $request)
    {
        // Lấy nhà tuyển dụng đã đăng nhập
        $employer = Auth::guard('tuyen_dung')->user();

        // Validation (xác thực)
        $validatedData = $request->validate([
            'ten_cong_ty' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('user_tuyen_dungs')->ignore($employer->id)],
            'tax_code' => ['required', 'string', 'max:20', Rule::unique('user_tuyen_dungs')->ignore($employer->id)],
            
            // Logo (có thể có hoặc không, kiểm tra định dạng)
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // max 2MB

            // Thông tin công ty
            'website' => ['nullable', 'string', 'max:255', 'url'],
            'phone' => ['required', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:20'],
            'province_id' => ['required', 'exists:provinces,id'],
            'ward_id' => ['required', 'exists:wards,id'],
            'address' => ['required', 'string', 'max:255'], // Số nhà, tên đường
            'company_introduction' => ['nullable', 'string'],
            'company_message' => ['nullable', 'string'],
            'operation_type' => ['required', Rule::in($this->operation_types)],
            'total_employees' => ['required', Rule::in($this->employee_counts)],
            
            // Người liên hệ
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_position' => ['nullable', 'string', 'max:255'],

            // Phúc lợi (phải là một mảng, và các giá trị phải tồn tại trong bảng benefits)
            'benefits' => ['nullable', 'array'],
            'benefits.*' => ['exists:benefits,id'],
        ]);

        // Xử lý tải lên Logo
        if ($request->hasFile('logo')) {
            // Xóa logo cũ (nếu có)
            if ($employer->logo) {
                // Giả sử bạn lưu trong 'storage/app/public/logos'
                // Tên file lưu trong DB sẽ là 'logos/filename.jpg'
                Storage::disk('public')->delete($employer->logo);
            }
            
            // Tải file mới lên và lấy đường dẫn
            // File sẽ được lưu vào 'storage/app/public/logos'
            $path = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $path; // Lưu đường dẫn tương đối vào CSDL
        }

        // Cập nhật thông tin cơ bản
        $employer->update($validatedData);

        // Cập nhật (đồng bộ) các phúc lợi (mối quan hệ
        // Bỏ qua nếu không có mảng 'benefits' (để giữ lại giá trị cũ nếu cần)
        if ($request->has('benefits')) {
            $employer->benefits()->sync($request->input('benefits', []));
        } else {
            // Nếu không gửi mảng 'benefits' (có thể do form disable),
            // chúng ta sync mảng rỗng (xóa hết phúc lợi)
             $employer->benefits()->sync([]);
        }

        return redirect()->route('employers.profile.edit')->with('success', 'Cập nhật thông tin công ty thành công!');
    }
}
