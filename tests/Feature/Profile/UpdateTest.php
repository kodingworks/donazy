<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function isCanBeUpdated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Fulan',
                'email' => 'fulan@example.com',
                'phone' => '123412341234',
            ]);

        $response->assertStatus(Response::HTTP_FOUND);
    }

    /** @test */
    public function isCanBeUpdatedPassword(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Fulan',
                'email' => 'fulan@example.com',
                'phone' => '123412341234',
                'old_password' => 'secret',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $user->refresh();

        $this->assertTrue(Hash::check('password', $user->password));
    }
}
