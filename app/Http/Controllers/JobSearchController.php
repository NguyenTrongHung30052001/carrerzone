<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Cần import Str nếu bạn muốn dùng nó để check slug

class JobSearchController extends Controller
{
    /**
     * Hiển thị trang tìm việc theo ngành nghề (Danh sách tất cả ngành nghề).
     */
    public function index()
    {
        // Lấy danh mục cha và kèm theo con (có đếm số bài đăng)
        $categories = Profession::where('is_category', true)
            ->where('trang_thai', 'enable')
            ->with(['children' => function ($query) {
                $query->where('trang_thai', 'enable')
                      ->withCount('posts'); // Đếm số bài đăng cho từng danh mục con
            }])
            ->orderBy('ten_nganh_nghe')
            ->get();

        return view('jobs.index', compact('categories'));
    }

    /**
     * Hiển thị danh sách việc làm theo một ngành nghề cụ thể (dựa vào SLUG).
     */
    public function showByProfession($slug)
    {
        // 1. Tìm ngành nghề dựa vào slug
        $profession = Profession::where('slug', $slug)
            ->where('trang_thai', 'enable')
            ->firstOrFail(); // Nếu không thấy slug này thì trả về lỗi 404

        // 2. Lấy danh sách bài đăng thuộc ngành nghề đó (có phân trang)
        //    Eager load 'employer' (để lấy logo) và 'province' (để lấy địa điểm)
        $posts = Post::where('profession_id', $profession->id)
            ->with(['employer', 'province']) 
            ->orderBy('created_at', 'desc') // Bài mới nhất lên đầu
            ->paginate(20); // Hiển thị 20 bài mỗi trang

        return view('jobs.by-profession', compact('profession', 'posts'));
    }

    /**
     * Hiển thị chi tiết một bài đăng tuyển dụng.
     * URL: /tim-viec-lam/{slug}.{id}.html
     */
    public function show($slug, $id)
    {
        // Tìm bài đăng theo ID.
        // Eager load tất cả các quan hệ cần thiết để hiển thị chi tiết.
        $post = Post::with(['employer.benefits', 'province', 'ward', 'profession'])
                    ->findOrFail($id);

        // (Tùy chọn nâng cao cho SEO)
        // Kiểm tra nếu slug trên URL không khớp với slug hiện tại của chức danh,
        // thì redirect 301 về URL đúng.
        $currentSlug = Str::slug($post->chuc_danh);
        if ($slug !== $currentSlug) {
             return redirect()->route('jobs.show', ['slug' => $currentSlug, 'id' => $id], 301);
        }

        return view('jobs.show', compact('post'));
    }
}