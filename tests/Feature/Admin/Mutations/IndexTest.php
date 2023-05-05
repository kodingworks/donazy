<?php

namespace Tests\Feature\Admin\Mutations;

use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::mutations.index'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
