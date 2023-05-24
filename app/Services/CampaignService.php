<?php

namespace  App\Services;

use App\Models\Campaign;

class CampaignService
{
  public function getData($request) {
    $search = $request->search;

    $query = Campaign::query()->published();

    $campaigns = PaginationService::make($query)->build();

    $campaigns->when($search, function ($query, $search) {
      return $query->where('campaigns.name', 'like', '%' . $search . '%');
    });
      
    return $campaigns;

  } 
}