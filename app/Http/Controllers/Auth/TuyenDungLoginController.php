<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class TuyenDungLoginController extends Controller
{
    /**
     * Hiển thị view đăng nhập của nhà tuyển dụng.
     */
    public function create(): View
    {
        return view('auth.tuyen-dung-login');
    }

    /**
     * Xử lý request đăng nhập.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::guard('tuyen_dung')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        // <<< ĐÃ CẬP NHẬT CHUYỂN HƯỚNG TẠI ĐÂY >>>
        return redirect()->intended(route('employers.dashboard'));
    }

    /**
     * Xử lý đăng xuất.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('tuyen_dung')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('employers.dashboard')); // Về lại trang employers công khai
    }
}