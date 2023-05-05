<?php

namespace Tests\Feature\Admin\Banners;

use App\Models\Banner;
use Tests\Feature\Admin\TestCase;

class EditTest extends TestCase
{
    /** @test */
    public function isShowForm(): void
    {
        $banner = Banner::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::banners.edit', $banner));

        $response->assertOk();
    }
}
