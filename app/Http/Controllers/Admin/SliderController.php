<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderStoreRequest;
use App\Http\Requests\Admin\SliderUpdateRequest;
use App\Models\Campaign;
use App\Models\Slider;
use App\Services\PaginationService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = PaginationService::make(Slider::query())
            ->setSearchables(['name'])
            ->build();

        return view('admin::sliders.index', [
            'sliders' => $sliders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin::sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SliderStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderStoreRequest $request)
    {
        $slider = Slider::create($request->validated());

        return redirect()
            ->route('admin::sliders.edit', $slider)
            ->with('success', __('crud.created', ['name' => 'slider']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        $campaigns = $slider->campaigns();

        return view('admin::sliders.show', [
            'slider' => $slider,
            'campaigns' => $campaigns,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $selectedCampaigns = $slider
            ->campaigns()
            ->map(function (Campaign $slider) {
                return $slider->only([
                    'id',
                    'name',
                ]);
            });

        return view('admin::sliders.edit', [
            'slider' => $slider,
            'selectedCampaigns' => $selectedCampaigns,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SliderUpdateRequest  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(SliderUpdateRequest $request, Slider $slider)
    {
        $slider->update($request->validated());

        return redirect()
            ->route('admin::sliders.edit', $slider)
            ->with('success', __('crud.updated', ['name' => 'slider']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()
            ->route('admin::sliders.index')
            ->with('success', __('crud.deleted', ['name' => 'slider']));
    }
}
