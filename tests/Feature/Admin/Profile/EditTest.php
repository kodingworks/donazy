<?php

namespace Tests\Feature\Admin\Profile;

use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class EditTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::profile.edit'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
