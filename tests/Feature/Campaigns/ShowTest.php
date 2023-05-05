<?php

namespace Tests\Feature\Campaigns;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function isCanBeRendered(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->published()->create();

        $response = $this->get(route('campaigns.show', ['slug' => $campaign->slug]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertSee($campaign->name);
    }

    /** @test */
    public function isErrorWhenCampaignNotPublished(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->create();

        $response = $this->get(route('campaigns.show', ['slug' => $campaign->slug]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
