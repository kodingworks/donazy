<?php

namespace Tests\Feature\Admin\Banners;

use Tests\Feature\Admin\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function isShowForm(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::banners.create'));

        $response->assertOk();
    }
}
