<?php

namespace Tests\Feature\Campaigns;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function isCanBeRendered(): void
    {
        $response = $this->get(route('campaigns.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function isDataExists(): void
    {
        /** @var Collection $campaigns */
        $campaigns = Campaign::factory(10)->published()->create();

        $response = $this->get(route('campaigns.index'));

        $response->assertStatus(Response::HTTP_OK);

        $campaigns->each(function (Campaign $campaign) use ($response) {
            $response->assertSee($campaign->name);
        });
    }

    /** @test */
    public function isCanSearchWithQueryString(): void
    {
        Campaign::factory(10)->published()->create();

        $response = $this->get(route('campaigns.index', ['search' => 'a']));

        $response->assertStatus(Response::HTTP_OK);

        /** @var Collection */
        $campaigns = Campaign::query()
            ->where('name', 'LIKE', '%a%')
            ->get();

        $campaigns->each(function (Campaign $campaign) use ($response) {
            $response->assertSee($campaign->name);
        });
    }
}
