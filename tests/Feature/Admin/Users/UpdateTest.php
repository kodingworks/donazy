<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Admin\TestCase;

class UpdateTest extends TestCase
{
    /**
     * @test
     */
    public function isUserUpdated(): void
    {
        $user = User::create([
            'name' => 'Fulan bin Fulan 2',
            'email' => 'fulan2@example.com',
            'phone' => '081321321321',
            'password' => 'secret',
        ]);

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::users.update', $user), [
                'name' => 'Fulan',
                'email' => 'fulan@example.co.id',
                'phone' => '123412341234',
                'password' => '12341234',
                'password_confirmation' => '12341234',
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $user->refresh();

        $this->assertEquals('Fulan', $user->name);
        $this->assertEquals('fulan@example.co.id', $user->email);
        $this->assertEquals('123412341234', $user->phone);
        $this->assertTrue(Hash::check('12341234', $user->password));
    }

    /** @test */
    public function isUserUpdatedToAdmin(): void
    {
        $user = User::create([
            'name' => 'Fulan bin Fulan 2',
            'email' => 'fulan2@example.com',
            'phone' => '081321321321',
            'password' => 'secret',
        ]);

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::users.update', $user), [
                'name' => 'Fulan',
                'email' => 'fulan@example.co.id',
                'phone' => '123412341234',
                'password' => '12341234',
                'password_confirmation' => '12341234',
                'admin' => 1,
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $user->refresh();

        $this->assertEquals('Fulan', $user->name);
        $this->assertEquals('fulan@example.co.id', $user->email);
        $this->assertEquals('123412341234', $user->phone);
        $this->assertTrue(Hash::check('12341234', $user->password));
        $this->assertTrue($user->isAdmin());
    }
}
