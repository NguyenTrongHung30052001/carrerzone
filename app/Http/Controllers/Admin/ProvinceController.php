<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function create()
    {
        return view('admin.provinces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_tinh_thanh_pho' => 'required|string|max:255|unique:provinces',
        ]);

        Province::create([
            'ten_tinh_thanh_pho' => $request->ten_tinh_thanh_pho,
            'trang_thai' => 'enable',
        ]);

        return redirect()->route('admin.locations.index')->with('success', 'Tạo Tỉnh/Thành phố mới thành công.');
    }

    public function edit(Province $province)
    {
        return view('admin.provinces.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'ten_tinh_thanh_pho' => 'required|string|max:255|unique:provinces,ten_tinh_thanh_pho,' . $province->id,
            'trang_thai' => 'required|in:enable,disable',
        ]);

        $province->update($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Cập nhật Tỉnh/Thành phố thành công.');
    }
}