<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Admin\TestCase;

class StoreTest extends TestCase
{
    /**
     * @test
     */
    public function isErrorWhenNameNull(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::users.store'), [
                'email' => 'fulan2@example.com',
                'phone' => '081321321321',
                'password' => '12341234',
                'password_confirmation' => '12341234',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    /**
     * @test
     */
    public function isErrorWhenEmailNull(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::users.store'), [
                'name' => 'Fulan bin Fulan',
                'phone' => '081321321321',
                'password' => '12341234',
                'password_confirmation' => '12341234',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['email']);
    }

    /**
     * @test
     */
    public function isErrorWhenPhoneNull(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::users.store'), [
                'name' => 'Fulan bin Fulan',
                'email' => 'fulan2@example.com',
                'password' => '12341234',
                'password_confirmation' => '12341234',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['phone']);
    }

    /**
     * @test
     */
    public function isErrorWhenPasswordNull(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::users.store'), [
                'name' => 'Fulan bin Fulan',
                'email' => 'fulan2@example.com',
                'phone' => '081321321321',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['password']);
    }

    /**
     * @test
     */
    public function isErrorWhenPasswordConfirmationDifferentWithPassword(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::users.store'), [
                'name' => 'Fulan bin Fulan',
                'email' => 'fulan2@example.com',
                'phone' => '081321321321',
                'password' => '12341234',
                'password_confirmation' => '43214321',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['password']);
    }

    /**
     * @test
     */
    public function isUserSaved(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::users.store'), [
                'name' => 'Fulan bin Fulan',
                'email' => 'fulan2@example.com',
                'phone' => '081321321321',
                'password' => '12341234',
                'password_confirmation' => '12341234',
            ]);

        $response->assertStatus(302);

        $user = User::where('email', 'fulan2@example.com')->first();

        $this->assertEquals('Fulan bin Fulan', $user->name);
        $this->assertEquals('081321321321', $user->phone);
        $this->assertTrue(Hash::check('12341234', $user->password));
    }

    /** @test */
    public function isUserWithAdminIsTrueSaved(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::users.store'), [
                'name' => 'Fulan bin Fulan',
                'email' => 'fulan2@example.com',
                'phone' => '081321321321',
                'password' => '12341234',
                'password_confirmation' => '12341234',
                'admin' => 1,
            ]);

        $response->assertStatus(302);

        /** @var User */
        $user = User::where('email', 'fulan2@example.com')->first();

        $this->assertEquals('Fulan bin Fulan', $user->name);
        $this->assertEquals('081321321321', $user->phone);
        $this->assertTrue(Hash::check('12341234', $user->password));
        $this->assertTrue($user->isAdmin());
    }
}
