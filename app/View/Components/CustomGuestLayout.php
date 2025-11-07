<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CustomGuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Chỉ dẫn cho Laravel: 
        // Khi ai đó gọi <x-custom-guest-layout>, hãy dùng file 'layouts.custom-guest-layout'
        return view('layouts.custom-guest-layout');
    }
}