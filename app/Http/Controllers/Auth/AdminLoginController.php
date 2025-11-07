<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Hiển thị view đăng nhập của admin.
     */
    public function create(): View
    {
        return view('auth.admin-login'); // Chúng ta sẽ tạo view này
    }

    /**
     * Xử lý request đăng nhập của admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Thử đăng nhập với guard 'admin' và trường 'username'
        if (!Auth::guard('admin')->attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'username' => __('auth.failed'), // Thông báo lỗi chung
            ]);
        }

        $request->session()->regenerate();

        // Chuyển hướng đến admin dashboard sau khi đăng nhập thành công
        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Xử lý đăng xuất của admin.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login')); // Về lại trang login admin
    }
}