<?php

namespace App\Http\Controllers;

use App\Models\Profession; // Import Model Ngành nghề
use Illuminate\Http\Request;
use Illuminate\View\View;


class JobSearchController extends Controller
{
    /**
     * Hiển thị trang danh sách việc làm theo ngành nghề.
     */
    public function index(): View
    {
        // 1. Lấy các danh mục cha (is_category = true) và tải kèm (eager load) các con
        $categories = Profession::where('is_category', true)
            ->where('trang_thai', 'enable')
            ->with(['children' => function ($query) {
                // Chỉ lấy 'con' (không phải danh mục) và đang 'enable'
                $query->where('is_category', false)
                    ->where('trang_thai', 'enable')
                    ->withCount('posts'); // Đếm số bài đăng
            }])
            ->orderBy('ten_nganh_nghe')
            ->get()
            // Lọc bớt các danh mục cha không có 'con' nào
            ->filter(function ($category) {
                return $category->children->isNotEmpty();
            });

        return view('jobs.index', compact('categories'));
    }
}
