<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    /**
     * Hiển thị danh sách gallery 2 cấp.
     */
    public function index()
    {
        // 1. Lấy các danh mục (cha) và tải kèm các ngành nghề (con)
        $categories = Profession::where('is_category', true)
                            ->with('children') // Tải 'children' relationship
                            ->orderBy('ten_nganh_nghe')
                            ->get();

        // 2. Lấy các ngành nghề "mồ côi"
        $orphans = Profession::where('is_category', false)
                           ->whereNull('parent_id')
                           ->orderBy('ten_nganh_nghe')
                           ->get();

        // 3. Gửi cả 2 biến cho view
        return view('admin.professions.index', compact('categories', 'orphans'));
    }

    /**
     * Hiển thị form tạo mới.
     */
    public function create()
    {
        // FIX: Lấy danh sách các danh mục cha để đưa vào dropdown
        $categories = Profession::where('is_category', true)
                            ->orderBy('ten_nganh_nghe')
                            ->get();
        
        // Gửi biến 'categories' cho view
        return view('admin.professions.create', compact('categories'));
    }

    /**
     * Lưu vào CSDL.
     */
    public function store(Request $request)
    {
        // Chuẩn hóa 'is_category'
        $request->merge([
            'is_category' => $request->boolean('is_category')
        ]);

        $request->validate([
            'ten_nganh_nghe' => 'required|string|max:255|unique:professions',
            'is_category' => 'required|boolean',
            'parent_id' => [
                'nullable',
                'required_if:is_category,false',
                'exists:professions,id'
            ],
        ]);

        Profession::create([
            'ten_nganh_nghe' => $request->ten_nganh_nghe,
            'is_category' => $request->is_category,
            'parent_id' => $request->is_category ? null : $request->parent_id,
            'trang_thai' => 'enable', // Mặc định
        ]);

        return redirect()->route('admin.professions.index')->with('success', 'Tạo ngành nghề/danh mục thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa.
     */
    public function edit(Profession $profession)
    {
        // *** FIX QUAN TRỌNG Ở ĐÂY ***
        // Lấy danh sách các danh mục cha để đưa vào dropdown
        $categories = Profession::where('is_category', true)
                            // Loại trừ chính nó (một danh mục không thể là con của chính nó)
                            ->where('id', '!=', $profession->id) 
                            ->orderBy('ten_nganh_nghe')
                            ->get();

        // Gửi cả 2 biến 'profession' (đang sửa) và 'categories' (danh sách cha)
        return view('admin.professions.edit', compact('profession', 'categories'));
    }

    /**
     * Cập nhật CSDL.
     */
    public function update(Request $request, Profession $profession)
    {
        // Chuẩn hóa 'is_category'
        $request->merge([
            'is_category' => $request->boolean('is_category')
        ]);

        $request->validate([
            'ten_nganh_nghe' => 'required|string|max:255|unique:professions,ten_nganh_nghe,' . $profession->id,
            'is_category' => 'required|boolean',
            'parent_id' => [
                'nullable',
                'required_if:is_category,false',
                'exists:professions,id'
            ],
            'trang_thai' => 'required|in:enable,disable',
        ]);

        $profession->update([
            'ten_nganh_nghe' => $request->ten_nganh_nghe,
            'is_category' => $request->is_category,
            'parent_id' => $request->is_category ? null : $request->parent_id,
            'trang_thai' => $request->trang_thai,
        ]);

        return redirect()->route('admin.professions.index')->with('success', 'Cập nhật ngành nghề/danh mục thành công.');
    }
}