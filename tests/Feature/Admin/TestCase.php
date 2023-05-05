<?php

namespace Tests\Feature\Admin;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
            'phone' => '081123123123',
            'password' => 'secret',
            'admin' => 1,
        ]);

        Event::fake(['eloquent.created: ' . Transaction::class]);
    }
}
