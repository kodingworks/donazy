<?php

namespace Tests\Feature\Admin\Profile;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Admin\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function isCanBeUpdated(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::profile.update'), [
                'name' => 'Fulan',
                'email' => 'fulan@example.com',
                'phone' => '123412341234',
            ]);

        $response->assertStatus(Response::HTTP_FOUND);
    }

    /** @test */
    public function isCanBeUpdatedPassword(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::profile.update'), [
                'name' => 'Fulan',
                'email' => 'fulan@example.com',
                'phone' => '123412341234',
                'old_password' => 'secret',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $this->user->refresh();

        $this->assertTrue(Hash::check('password', $this->user->password));
    }
}
