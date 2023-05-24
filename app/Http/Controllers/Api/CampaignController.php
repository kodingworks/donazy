<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Campaign\CampaignListResource;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\PaginationService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{   
    private $campaignService;
    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
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

            $data = $this->campaignService->getData($request);

            $campaigns = new CampaignListResource($data);
            
            return $campaigns;

        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get campaign list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDetail() {
        try{

            $campaign = $this->campaignService->getDetail();

            return new CampaignResource($campaign);

        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get campaign detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
