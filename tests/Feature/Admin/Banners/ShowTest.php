<?php

namespace Tests\Feature\Admin\Banners;

use App\Models\Banner;
use Tests\Feature\Admin\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        $banner = Banner::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::banners.show', $banner));

        $response->assertOk();
    }
}
