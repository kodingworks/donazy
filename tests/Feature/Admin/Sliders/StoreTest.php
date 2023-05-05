<?php

namespace Tests\Feature\Admin\Sliders;

use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class StoreTest extends TestCase
{
    /** @test */
    public function isErrorWhenNameIsNull(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::sliders.store'), [
                'campaign_ids' => ['1', '2', '3'],
            ]);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function isErrorWhenCampaignIdsIsNull(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::sliders.store'), [
                'name' => 'Some string',
            ]);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['campaign_ids']);
    }

    /** @test */
    public function isErrorWhenCampaignIdsIsNotInteger(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::sliders.store'), [
                'campaign_ids' => ['one', 'two', 'three'],
            ]);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['campaign_ids.*']);
    }

    /** @test */
    public function isCanBeSaved(): void
    {
        $this->withoutExceptionHandling();

        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::sliders.store'), [
                'name' => 'Some slider',
                'campaign_ids' => ['1', '2', '3'],
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('sliders', [
            'name' => 'Some slider',
            'campaign_ids' => '["1","2","3"]',
        ]);
    }
}
