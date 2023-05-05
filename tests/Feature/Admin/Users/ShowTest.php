<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\Feature\Admin\TestCase;

class ShowTest extends TestCase
{
    /**
     * @test
     */
    public function isShowDetail(): void
    {
        $user = User::create([
            'name' => 'Fulan bin Fulan 2',
            'phone' => '081321321321',
            'email' => 'fulan2@example.com',
            'password' => 'secret'
        ]);

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::users.show', $user));

        $response->assertStatus(200)
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee($user->phone)
            ->assertSee($user->created_at);
    }
}
