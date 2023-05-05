<?php

namespace Tests\Feature\Admin\Campaigns;

use App\Models\Campaign;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class ShowTest extends TestCase
{
    /**
     * @test
     */
    public function isShowDetailCampaign(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->published()->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::campaigns.show', $campaign));

        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('admin::campaigns.show')
            ->assertSee($campaign->name)
            ->assertSee($campaign->slug)
            ->assertSee($campaign->original_cover_url)
            ->assertSee(number_format($campaign->funds, 0, ',', '.'))
            ->assertSee($campaign->published_at);
    }
}
