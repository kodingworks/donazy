<?php

namespace Tests\Feature\Admin\Auth;

use Tests\Feature\Admin\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     */
    public function isShowForm(): void
    {
        $response = $this->get(route('admin::auth.login'));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function isErrorWhenWrongCredential(): void
    {
        $response = $this->post(route('admin::auth.login'), [
            'email' => 'fulan@example.com',
            'password' => '123123',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['email']);
    }

    /**
     * @test
     */
    public function isCanAuthenticate(): void
    {
        $response = $this->post(route('admin::auth.login'), [
            'email' => 'fulan@example.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/admin');

        $this->assertAuthenticated();
    }

    /**
     * @test
     */
    public function isCanLogout(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::auth.logout'));

        $response->assertStatus(302)
            ->assertRedirect(route('admin::auth.login'));

        $this->assertFalse($this->isAuthenticated());
    }
}
