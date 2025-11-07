<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // SỬA ĐỔI TỪ ĐÂY:
        // Kiểm tra xem URL có phải là dành cho admin không
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }

        // Kiểm tra xem URL có phải là dành cho nhà tuyển dụng không
        // (Chúng ta chỉ bảo vệ các route 'employers/*' nào dùng auth:tuyen_dung)
        if ($request->is('employers/*')) {
            return route('employers.login');
        }

        // Mặc định, chuyển về trang login của 'web' (ung_vien)
        return route('login');
    }
}