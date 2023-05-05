<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\Feature\Admin\TestCase;

class EditTest extends TestCase
{
    /**
     * @test
     */
    public function isShowForm(): void
    {
        $user = User::create([
            'name' => 'Fulan bin Fulan 2',
            'email' => 'fulan2@example.com',
            'phone' => '081321321321',
            'password' => 'secret',
        ]);

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::users.edit', $user));

        $response->assertStatus(200)
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee($user->phone);
    }
}
