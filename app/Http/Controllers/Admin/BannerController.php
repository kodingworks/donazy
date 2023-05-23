<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerStoreRequest;
use App\Http\Requests\Admin\BannerUpdateRequest;
use App\Models\Banner;
use App\Services\PaginationService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Banner::query()->orderBy('sort');
        $banners = PaginationService::make($query)->build();

        return view('admin::banners.index', [
            'banners' => $banners,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin::banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\BannerStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerStoreRequest $request)
    {
        /** @var Banner */
        $banner = Banner::create($request->validation());

        if ($request->hasFile('image')) {
            $banner->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()
            ->route('admin::banners.edit', $banner)
            ->with('success', __('crud.created', ['name' => 'banner']));
    }

    /**
     * Display the specified resource.
     *
     * @param  Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return view('admin::banners.show', [
            'banner' => $banner,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin::banners.edit', [
            'banner' => $banner,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\BannerUpdateRequest $request
     * @param \App\Models\Banner $banner
     * @return \Illuminate\hTTp\Response
     */
    public function update(BannerUpdateRequest $request, Banner $banner)
    {
        $banner->update($request->validated());

        return redirect()
            ->route('admin::banners.edit', $banner)
            ->with('success', __('crud.updated', ['name' => 'banner']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->clearMediaCollection();
        $banner->delete();

        return redirect()
            ->route('admin::banners.index')
            ->with('success', __('crud.deleted', ['name' => 'banner']));
    }
}
