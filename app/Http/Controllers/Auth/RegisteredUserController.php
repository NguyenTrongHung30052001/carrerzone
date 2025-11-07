<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route; // Cần import cái này
use App\Providers\RouteServiceProvider; // Cần import cái này

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // BƯỚC 2A: THAY ĐỔI VALIDATION (ĐÃ THÊM 'terms')
        $request->validate([
            'ho_va_ten_lot' => ['required', 'string', 'max:255'],
            'ten' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'], // Bắt buộc phải tích
        ]);

        // BƯỚC 2B: THAY ĐỔI LOGIC LƯU TRỮ
        // Xóa 'name' và thêm 'ho_va_ten_lot' và 'ten'
        $user = User::create([
            'ho_va_ten_lot' => $request->ho_va_ten_lot,
            'ten' => $request->ten,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Đảm bảo dùng đúng RouteServiceProvider::HOME
        return redirect(RouteServiceProvider::HOME);
    }
}