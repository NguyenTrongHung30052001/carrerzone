<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Chỉ dẫn cho Laravel: 
        // Khi ai đó gọi <x-admin-layout>, hãy dùng file 'layouts.admin'
        return view('layouts.admin');
    }
}