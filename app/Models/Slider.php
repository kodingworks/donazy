<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setCampaignIdsAttribute($value): void
    {
        $this->attributes['campaign_ids'] = json_encode($value);
    }

    public function getArrayCampaignIdsAttribute(): array
    {
        return json_decode($this->campaign_ids);
    }

    public function campaigns()
    {
        return Campaign::query()
            ->published()
            ->whereIn('id', $this->array_campaign_ids)
            ->orderByRaw('FIELD(id,' . implode(',', $this->array_campaign_ids) . ')')
            ->get();
    }
}
