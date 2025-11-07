<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function create()
    {
        // Cần lấy danh sách tỉnh để tạo dropdown
        $provinces = Province::where('trang_thai', 'enable')->orderBy('ten_tinh_thanh_pho')->get();
        return view('admin.wards.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_xa_phuong' => 'required|string|max:255',
            'id_parent' => 'required|exists:provinces,id',
        ]);

        Ward::create([
            'ten_xa_phuong' => $request->ten_xa_phuong,
            'id_parent' => $request->id_parent,
            'trang_thai' => 'enable',
        ]);

        return redirect()->route('admin.locations.index')->with('success', 'Tạo Xã/Phường mới thành công.');
    }

    public function edit(Ward $ward)
    {
        // Cần danh sách tỉnh để chọn lại
        $provinces = Province::orderBy('ten_tinh_thanh_pho')->get();
        return view('admin.wards.edit', compact('ward', 'provinces'));
    }

    public function update(Request $request, Ward $ward)
    {
        $request->validate([
            'ten_xa_phuong' => 'required|string|max:255',
            'id_parent' => 'required|exists:provinces,id',
            'trang_thai' => 'required|in:enable,disable',
        ]);

        $ward->update($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Cập nhật Xã/Phường thành công.');
    }
}