<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\PaginationService;
use Request;

class CampaignController extends Controller
{   

    public function __construct(OrderServices $orderServices)
    {
        $this->orderServices = $orderServices;
    }

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

            $data = $this->campaignService->getList($request);

            
            
            return $campaigns;

        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get campaign list',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
