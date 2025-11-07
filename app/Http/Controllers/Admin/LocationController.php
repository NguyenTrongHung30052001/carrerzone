<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Hiển thị trang index chính, chứa cả 2 danh sách
     */
    public function index()
    {
        $provinces = Province::orderBy('ten_tinh_thanh_pho')->get();
        
        // Eager load 'province' để tránh N+1 query
        $wards = Ward::with('province')->orderBy('ten_xa_phuong')->get(); 

        return view('admin.locations.index', compact('provinces', 'wards'));
    }
}