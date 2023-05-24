<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\PaginationService;
use Request;

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

    public function getList(Request $request) {
        try{

            $campaigns = PaginationService::make($query)
            ->setSearchables([
                'name',
            ]);
            return "";
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get campaign list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
