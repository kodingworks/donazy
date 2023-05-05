<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    /**
     * @return View
     */
    public function render()
    {
        return view('layouts.admin');
    }
}
