<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\PaginationService;

class CampaignController extends Controller
{
    /**
     * Display listing resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = PaginationService::make(Campaign::query())
            ->setSearchables([
                'name',
                'slug',
            ])
            ->build();

        return CampaignResource::collection($campaigns);
    }
}
