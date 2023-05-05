<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\Feature\Admin\TestCase;

class DeleteTest extends TestCase
{
    /**
     * @test
     */
    public function isUserDeleted()
    {
        $user = User::create([
            'name' => 'Fulan bin Fulan 2',
            'email' => 'fulan2@example.com',
            'phone' => '081321321321',
            'password' => 'secret',
        ]);

        $response = $this
            ->actingAs($this->user)
            ->delete(route('admin::users.destroy', $user));

        $response->assertStatus(302);

        $this->assertNull(User::find($user->id));
    }
}
