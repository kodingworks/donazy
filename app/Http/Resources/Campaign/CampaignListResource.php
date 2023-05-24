<?php

namespace App\Http\Resources\Campaign;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this
            ->resource
            ->makeHidden(['media', "original_cover_url", "unique_code_sufix", "published_at", "created_at", "updated_at"]);

        return parent::toArray($request);
    }
}
