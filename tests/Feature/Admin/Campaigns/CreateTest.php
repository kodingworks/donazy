<?php

namespace Tests\Feature\Admin\Campaigns;

use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class CreateTest extends TestCase
{
    /**
     * @test
     */
    public function isShowFrom(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::campaigns.create'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertViewIs('admin::campaigns.create');
    }
}
