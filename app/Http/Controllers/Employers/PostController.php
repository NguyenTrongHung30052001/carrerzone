<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Profession;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Hiển thị danh sách tin đăng của nhà tuyển dụng.
     */
    public function index()
    {
        // Lấy tin đăng CHỈ của nhà tuyển dụng đã đăng nhập
        $posts = Post::where('user_tuyen_dung_id', Auth::guard('tuyen_dung')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employers.posts.index', compact('posts'));
    }

    /**
     * Hiển thị form tạo tin đăng mới.
     */
    public function create()
    {
        // 1. Lấy danh mục cha (is_category = true) và tải kèm (eager load) các con
        $categories = Profession::where('is_category', true)
            ->with(['children' => function ($query) {
                // Chỉ lấy 'con' (không phải danh mục) và đang 'enable'
                $query->where('is_category', false)
                    ->where('trang_thai', 'enable');
            }])
            ->where('trang_thai', 'enable')
            ->orderBy('ten_nganh_nghe')
            ->get()
            // Lọc bớt các danh mục cha không có 'con' nào đang 'enable'
            ->filter(function ($category) {
                return $category->children->isNotEmpty();
            });

        // 2. Lấy Tỉnh/Thành
        $provinces = Province::where('trang_thai', 'enable')->orderBy('ten_tinh_thanh_pho')->get();

        // 3. Gửi cả 2 biến cho view
        return view('employers.posts.create', compact('categories', 'provinces'));
    }

    /**
     * Lưu tin đăng mới vào CSDL.
     */
    public function store(Request $request)
    {
        $employer = Auth::guard('tuyen_dung')->user();

        // Cập nhật validation để khớp với tên cột mới
        $validated = $request->validate([
            'chuc_danh' => 'required|string|max:255',
            'profession_id' => [
                'required',
                'exists:professions,id',
                // Đảm bảo profession_id KHÔNG phải là danh mục cha
                Rule::exists('professions', 'id')->where('is_category', false)
            ],
            'province_id' => 'required|exists:provinces,id',
            'ward_id' => 'required|exists:wards,id',
            'dia_chi_lam_viec' => 'required|string|max:255',
            'mo_ta_cong_viec' => 'required|string',
            'yeu_cau_cong_viec' => 'required|string',
            'luong_currency' => 'required|in:USD,VNĐ', // Đổi từ salary_type
            'luong_from' => 'nullable|numeric|min:0', // Đổi từ salary_from
            'luong_to' => 'nullable|numeric|min:0|gte:luong_from', // Đổi từ salary_to
            'luong_hien_thi' => 'nullable', // Đổi từ show_salary
            'hinh_thuc' => 'nullable|array',
            'han_chot_nop_ho_so' => 'required|date|after_or_equal:today',
            'yeu_cau_thu_gioi_thieu' => 'required|string|max:100', // Đổi từ thu_gioi_thieu
            'ngon_ngu_ho_so' => 'nullable|array',
            'gioi_tinh' => 'required|string|max:50',
            'tuoi_from' => 'nullable|integer|min:18|max:100', // Đổi từ tuoi_tu
            'tuoi_to' => 'nullable|integer|gte:tuoi_from|max:100', // Đổi từ tuoi_den
            'kinh_nghiem' => 'required|string|max:100',
            'cap_bac' => 'required|string|max:100',
            'bang_cap' => 'required|string|max:100',
            'thong_tin_khac' => 'nullable|string',
        ], [
            'profession_id.exists' => 'Ngành nghề bạn chọn không hợp lệ (có thể bạn đã chọn danh mục cha).'
        ]);

        // 1. Xử lý 'luong_hien_thi' (checkbox)
        $validated['luong_hien_thi'] = $request->boolean('luong_hien_thi');
        // 2. FIX LỖI 1364: Đảm bảo các trường array luôn là mảng rỗng nếu không có giá trị
        $validated['hinh_thuc'] = $validated['hinh_thuc'] ?? [];

        $validated['ngon_ngu_ho_so'] = $validated['ngon_ngu_ho_so'] ?? [];

        // 3. Thêm các thông tin tự động từ nhà tuyển dụng (giữ nguyên)
        $validated['user_tuyen_dung_id'] = $employer->id;
        $validated['ten_cong_ty'] = $employer->ten_cong_ty;

        // Lấy thông tin Tỉnh/Thành phố và Phường/Xã làm việc từ ID
        $postProvince = Province::find($validated['province_id']);
        $postWard = Ward::find($validated['ward_id']);

        // Gán tên Tỉnh/Thành phố và Phường/Xã làm việc
        $validated['province_name'] = $postProvince->ten_tinh_thanh_pho ?? null;
        $validated['ward_name'] = $postWard->ten_xa_phuong ?? null;

        // Lấy địa chỉ công ty từ thông tin của nhà tuyển dụng (lấy từ dữ liệu đăng ký của Employer)
        $employer->load('province', 'ward');
        $validated['dia_chi_cong_ty'] = ($employer->province->ten_tinh_thanh_pho ?? '');

        // Gán người liên hệ và email (tự động điền)
        $validated['nguoi_lien_he'] = $employer->contact_name; // Lấy từ contact_name của employer
        $validated['email_lien_he'] = $employer->email;
        // Tạo tin đăng

        // dd($request['luong_to'] );



        Post::create($validated);

        return redirect()->route('employers.posts.index')->with('success', 'Tạo tin đăng thành công!');
    }

    /**
     * Hiển thị (Chúng ta không dùng trang show)
     */
    public function show(Post $post)
    {
        return redirect()->route('employers.posts.index');
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit(Post $post)
    {
        // (Sẽ được thêm vào ở bước sau)
        abort(404);
    }

    /**
     * Cập nhật tin đăng
     */
    public function update(Request $request, Post $post)
    {
        // (Sẽ được thêm vào ở bước sau)
        abort(404);
    }

    /**
     * Xóa tin đăng
     */
    public function destroy(Post $post)
    {
        // (Sẽ được thêm vào ở bước sau)
        abort(404);
    }
}
