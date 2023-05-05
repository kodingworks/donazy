<?php

namespace Tests\Feature\Admin\Sliders;

use App\Models\Campaign;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        /** @var Collection */
        $campaigns = Campaign::factory(3)
            ->published()
            ->create();

        /** @var Slider */
        $slider = Slider::factory()
            ->state([
                'campaign_ids' => $campaigns->pluck('id')->toArray(),
            ])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::sliders.show', $slider));

        $response->assertStatus(Response::HTTP_OK);
    }
}
