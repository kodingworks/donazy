<?php

namespace Tests\Feature\Admin\Campaigns;

use App\Models\Campaign;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class DeleteTest extends TestCase
{
    /**
     * @test
     */
    public function isDeleted(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->published()->create();

        $response = $this
            ->actingAs($this->user)
            ->delete(route('admin::campaigns.destroy', $campaign));

        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertNull(Campaign::find($campaign->id));
    }
}
