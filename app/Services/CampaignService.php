<?php

namespace  App\Services;

use App\Models\Campaign;
use App\Models\Transaction;

class CampaignService
{
  public function getData() {

    $query = Campaign::query()->published();

    $query = PaginationService::make($query)
            ->setSearchables([
                'name',
            ])
            ->build();
      

    return $query;
  } 

  public function getDetail($slug) {
    $query = Campaign::query()
    ->where('slug', $slug)
    ->published()
    ->firstOrFail();

    return $query;
  }

  public function getDonors($slug) {
    $query = Campaign::query()
    ->where('slug', $slug)
    ->published()
    ->firstOrFail();

    $transactions = $query
    ->transactions()
    ->where('status', Transaction::STATUS_PAID)
    ->latest('updated_at')
    ->limit(9)
    ->get();

    return $transactions;
  }
}