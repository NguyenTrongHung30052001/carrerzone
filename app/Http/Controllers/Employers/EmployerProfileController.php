<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Province;
use App\Models\Benefit;
use Illuminate\Support\Facades\Storage; // Cần cho việc xóa file logo cũ
use Illuminate\Validation\Rule;

class EmployerProfileController extends Controller
{
    // Các tùy chọn dropdown (giống TuyenDungRegisterController)
    protected $operation_types = [
        '100% vốn nước ngoài', 'Cá nhân', 'Công ty đa quốc gia', 'Cổ phần', 'Liên doanh', 'Nhà nước', 'Trách nhiệm hữu hạn'
    ];

    protected $employee_counts = [
        'Ít hơn 10', '10-20', '25-99', '100-499', '500-999', '1.000-4.999', '5.000-9.999', '10.000-19.999', '20.000-49.999', 'Hơn 50.000'
    ];


    /**
     * Hiển thị form chỉnh sửa profile.
     */
    public function edit(Request $request): View
    {
        $user = Auth::guard('tuyen_dung')->user();

        // Lấy dữ liệu cho các dropdown
        $provinces = Province::where('trang_thai', 'enable')->orderBy('ten_tinh_thanh_pho')->get();
        $benefits = Benefit::where('trang_thai', 'enable')->orderBy('ten_phuc_loi')->get();
        
        // Lấy danh sách ID các phúc lợi mà nhà tuyển dụng này đã chọn
        // Eager load 'benefits' relationship, sau đó lấy 'pluck' (chỉ lấy) ra 'id'
        // và chuyển sang array.
        $currentBenefits = $user->benefits()->pluck('benefits.id')->toArray();

        return view('employers.profile.edit', [
            'user' => $user,
            'provinces' => $provinces,
            'benefits' => $benefits,
            'currentBenefits' => $currentBenefits, // Gửi danh sách ID phúc lợi đã chọn
            'operation_types' => $this->operation_types,
            'employee_counts' => $this->employee_counts,
        ]);
    }

    /**
     * Cập nhật thông tin chính của profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::guard('tuyen_dung')->user();

        // Validate dữ liệu
        $validatedData = $request->validate([
            'ten_cong_ty' => ['required', 'string', 'max:255'],
            'tax_code' => [
                'required', 'string', 'max:20',
                Rule::unique('user_tuyen_dungs')->ignore($user->id), // Bỏ qua chính user này
            ],
            'website' => ['nullable', 'url', 'max:255'],
            'operation_type' => ['nullable', 'string', Rule::in($this->operation_types)],
            'total_employees' => ['nullable', 'string', Rule::in($this->employee_counts)],
            'company_introduction' => ['nullable', 'string'],
            'company_message' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_position' => ['nullable', 'string', 'max:255'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'ward_id' => ['nullable', 'exists:wards,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:20'],
            'benefits' => ['nullable', 'array'], // Validate 'benefits' là một mảng
            'benefits.*' => ['exists:benefits,id'], // Validate mỗi ID trong mảng benefits
        ]);

        // Cập nhật thông tin user
        $user->fill($validatedData);

        // Lưu thông tin
        $user->save();

        // Cập nhật phúc lợi (Mối quan hệ Nhiều-Nhiều)
        // 'sync' sẽ tự động thêm/xóa các phúc lợi trong bảng trung gian
        if ($request->has('benefits')) {
            $user->benefits()->sync($request->benefits);
        } else {
            // Nếu không gửi mảng 'benefits' (tức là bỏ check tất cả),
            // 'sync' với mảng rỗng để xóa hết
            $user->benefits()->sync([]);
        }

        return Redirect::route('employers.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Cập nhật logo công ty.
     */
    public function updateLogo(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Giới hạn 2MB
        ]);

        $user = Auth::guard('tuyen_dung')->user();

        // Xóa logo cũ (nếu có)
        if ($user->logo) {
            // Giả sử logo được lưu trong 'public/logos'
            // 'storage/' là symlink của 'public/storage'
            // 'public/logos/...' tương ứng 'storage/app/public/logos/...'
            $oldPath = str_replace('storage/', 'public/', $user->logo);
            Storage::delete($oldPath);
        }

        // Tải logo mới lên và lưu đường dẫn
        // 'store' sẽ tự động tạo tên file unique
        // 'public/logos' là thư mục bên trong 'storage/app/public/logos'
        $path = $request->file('logo')->store('public/logos');

        // Cập nhật đường dẫn logo trong CSDL
        // Thay thế 'public/' bằng 'storage/' để dùng link public
        $user->logo = str_replace('public/', 'storage/', $path);
        $user->save();

        return Redirect::route('employers.profile.edit')->with('status', 'logo-updated');
    }
}