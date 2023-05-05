<?php

namespace Tests\Feature\Campaigns\Transactions;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function isCanBeRenderedWhenClosedAtIsNull(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->create();

        $response = $this->get(route('campaigns.transactions.create', ['slug' => $campaign->slug]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertSee($campaign->name);
    }

    /** @test */
    public function isCanBeRenderedWhenStillAvailable(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $response = $this->get(route('campaigns.transactions.create', ['slug' => $campaign->slug]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertSee($campaign->name);
    }

    /** @test */
    public function isNotFoundWhenAlreadyClosed(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->closed()
            ->create();

        $response = $this->get(route('campaigns.transactions.create', ['slug' => $campaign->slug]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
