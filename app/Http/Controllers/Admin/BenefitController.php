<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    /**
     * Hiển thị danh sách phúc lợi.
     */
    public function index()
    {
        $benefits = Benefit::all();
        return view('admin.benefits.index', compact('benefits'));
    }

    /**
     * Hiển thị form tạo mới.
     */
    public function create()
    {
        return view('admin.benefits.create');
    }

    /**
     * Lưu phúc lợi mới vào CSDL.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_phuc_loi' => 'required|string|max:255|unique:benefits',
        ]);

        Benefit::create([
            'ten_phuc_loi' => $request->ten_phuc_loi,
            'trang_thai' => 'enable', // Mặc định là 'enable' khi tạo mới
        ]);

        return redirect()->route('admin.benefits.index')->with('success', 'Tạo phúc lợi mới thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa.
     * (Sử dụng Route Model Binding để tự động tìm $benefit)
     */
    public function edit(Benefit $benefit)
    {
        return view('admin.benefits.edit', compact('benefit'));
    }

    /**
     * Cập nhật phúc lợi trong CSDL.
     */
    public function update(Request $request, Benefit $benefit)
    {
        $request->validate([
            // Đảm bảo tên là unique, nhưng bỏ qua ID của chính nó
            'ten_phuc_loi' => 'required|string|max:255|unique:benefits,ten_phuc_loi,' . $benefit->id,
            'trang_thai' => 'required|in:enable,disable', // Chỉ cho phép 2 giá trị
        ]);

        $benefit->update($request->all());

        return redirect()->route('admin.benefits.index')->with('success', 'Cập nhật phúc lợi thành công.');
    }

    /**
     * (Không có hàm destroy() vì bạn yêu cầu không được xóa)
     */
}