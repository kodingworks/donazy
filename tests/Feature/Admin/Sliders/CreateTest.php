<?php

namespace Tests\Feature\Admin\Sliders;

use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::sliders.create'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
