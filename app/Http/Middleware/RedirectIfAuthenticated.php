<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure; // Đảm bảo đã import Closure
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? ['web'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Tùy chỉnh chuyển hướng dựa trên guard
                switch ($guard) {
                    case 'admin':
                        return redirect(route('admin.dashboard')); // Chuyển đến /admin
                    case 'tuyen_dung':
                        // Chuyển hướng nhà tuyển dụng đến dashboard của họ
                        return redirect(route('employers.dashboard')); 
                    default:
                        // Mặc định là guard 'web' (ung_vien)
                        return redirect(RouteServiceProvider::HOME); // Thường là /dashboard
                }
            }
        }

        return $next($request);
    }
}