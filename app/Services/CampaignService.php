<?php

namespace  App\Services;

use App\Models\Campaign;

class CampaignService
{
  public function getData() {

    $query = Campaign::query()->published();

    $campaigns = PaginationService::make($query)
            ->setSearchables([
                'name',
            ])
            ->build();
      

    return $campaigns;
  } 

  public function getDetail() {
    $campaign = Campaign::query()->published()->first();

    return $campaign;
  }
}