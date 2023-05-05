<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\Feature\Admin\TestCase;

class IndexTest extends TestCase
{
    /**
     * @test
     */
    public function isGiveASuccessfulResponse()
    {
        $user = User::create([
            'name' => 'Fulan bin Fulan 2',
            'phone' => '081321321321',
            'email' => 'fulan2@example.com',
            'password' => 'secret'
        ]);

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::users.index'));

        $response->assertStatus(200)
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee($user->phone);
    }
}
