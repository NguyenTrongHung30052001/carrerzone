<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class EmployersGuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Chỉ dẫn cho Laravel: 
        // Khi ai đó gọi <x-employers-guest-layout>, hãy dùng file 'layouts.employers-guest-layout'
        return view('layouts.employers-guest-layout');
    }
}