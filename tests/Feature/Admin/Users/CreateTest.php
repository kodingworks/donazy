<?php

namespace Tests\Feature\Admin\Users;

use Tests\Feature\Admin\TestCase;

class CreateTest extends TestCase
{
    /**
     * @test
     */
    public function isShowForm()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::users.create'));

        $response->assertStatus(200);
    }
}
