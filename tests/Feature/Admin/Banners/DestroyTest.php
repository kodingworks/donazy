<?php

namespace Tests\Feature\Admin\Banners;

use App\Models\Banner;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class DestroyTest extends TestCase
{
    /** @test */
    public function isDeleted(): void
    {
        $banner = Banner::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->delete(route('admin::banners.destroy', $banner));

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionDoesntHaveErrors();
    }
}
