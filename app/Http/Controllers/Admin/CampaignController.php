<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CampaignStoreRequest;
use App\Http\Requests\Admin\CampaignUpdateRequest;
use App\Models\Campaign;
use App\Services\PaginationService;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = PaginationService::make(Campaign::query())
            ->setSearchables([
                'name',
                'slug',
                'funds',
                'collected_funds',
                'published_at',
                'closed_at',
            ])
            ->build();

        return view('admin::campaigns.index', [
            'campaigns' => $campaigns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin::campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CampaignStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignStoreRequest $request)
    {
        $campaign = Campaign::create($request->validation());

        if ($request->hasFile('cover')) {
            $campaign->addMediaFromRequest('cover')->toMediaCollection();
        }

        return redirect()
            ->route('admin::campaigns.edit', $campaign)
            ->with('success', __('crud.created', ['name' => 'campaign']));
    }

    /**
     * Display the specified resource.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return view('admin::campaigns.show', ['campaign' => $campaign]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('admin::campaigns.edit', ['campaign' => $campaign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CampaignUpdateRequest  $request
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignUpdateRequest $request, Campaign $campaign)
    {
        $campaign->update($request->validation());

        if ($request->hasFile('cover')) {
            $campaign->clearMediaCollection();
            $campaign->addMediaFromRequest('cover')->toMediaCollection();
        }

        return redirect()
            ->route('admin::campaigns.edit', $campaign)
            ->with('success', __('crud.updated', ['name' => 'campaign']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->clearMediaCollection();
        $campaign->delete();

        return redirect()
            ->route('admin::campaigns.index')
            ->with('success', __('crud.deleted', ['name' => 'campaign']));
    }
}
