<?php

namespace Tests\Feature\Admin\Banners;

use App\Models\Banner;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function isUpdated(): void
    {
        $banner = Banner::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::banners.update', $banner), ['sort' => 10]);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('banners', ['sort' => 10]);
    }
}
