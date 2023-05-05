<?php

namespace Tests\Feature\Admin\Campaigns;

use App\Models\Campaign;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class IndexTest extends TestCase
{
    /**
     * @test
     */
    public function isRenderAView(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::campaigns.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('admin::campaigns.index');
    }

    /**
     * @test
     */
    public function isShowCampaigns(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::campaigns.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertSee($campaign->id)
            ->assertSee($campaign->name)
            ->assertSee($campaign->slug)
            ->assertSee(number_format($campaign->funds, 0, ',', '.'))
            ->assertSee(number_format($campaign->collected_funds, 0, ',', '.'))
            ->assertSee($campaign->published_at)
            ->assertSee($campaign->closed_at);
    }
}
