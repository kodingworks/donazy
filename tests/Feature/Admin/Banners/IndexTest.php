<?php

namespace Tests\Feature\Admin\Banners;

use Tests\Feature\Admin\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::banners.index'));

        $response->assertOk();
    }
}
