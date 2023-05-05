<?php

namespace Tests\Feature\Admin\Campaigns;

use App\Models\Campaign;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class EditTest extends TestCase
{
    /**
     * @test
     */
    public function isShowEditForm(): void
    {
        $campaign = Campaign::factory()->published()->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::campaigns.edit', $campaign));

        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('admin::campaigns.edit')
            ->assertSee($campaign->name)
            ->assertSee($campaign->slug)
            ->assertSee($campaign->funds);
    }
}
