<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class EditTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
