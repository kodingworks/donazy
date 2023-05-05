<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners = Banner::query()
            ->orderBy('sort')
            ->latest('updated_at')
            ->get();

        $sliders = Slider::query()
            ->orderBy('sort')
            ->orderByDesc('id')
            ->get()
            ->map(function (Slider $slider) {
                $slider->campaigns = $slider->campaigns();

                return $slider;
            })
            ->filter(function (Slider $slider) {
                return $slider->campaigns->isNotEmpty();
            });

        return view('home', [
            'banners' => $banners,
            'sliders' => $sliders,
        ]);
    }
}
