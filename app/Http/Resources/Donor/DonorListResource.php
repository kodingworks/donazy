<?php

namespace App\Http\Resources\Donor;

use Illuminate\Http\Resources\Json\JsonResource;

class DonorListResource extends JsonResource
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
            ->makeHidden(['code', "campaign_id", "user_id", "user_email", "user_phone", "unique_code", "amount", "status", "meta", "updated_at"]);

        $data = parent::toArray($request);
        foreach ($data as &$item) {
            if (isset($item['anonymous']) && $item['anonymous'] == 1) {
                $item['donor_name'] = 'Hamba Allah';
                unset($item['user_name']);
            } else {
                $item['donor_name'] = $item['user_name'];
                unset($item['user_name']);
            }
        }    
    
        return $data;
    }
}
