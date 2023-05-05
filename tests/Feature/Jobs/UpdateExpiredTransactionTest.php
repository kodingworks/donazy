<?php

namespace Tests\Feature\Jobs;

use App\Jobs\UpdateExpiredTransaction;
use App\Models\Campaign;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateExpiredTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function isTransactionStatusUpdatedToExpired(): void
    {
        Event::fake(['eloquent.created: ' . Transaction::class]);

        /** @var User */
        $user = User::factory()->create();

        /** @var Campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $campaign->transactions()->create([
            'amount' => 10000,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
        ]);

        /** @var Transaction */
        $transaction = Transaction::first();

        UpdateExpiredTransaction::dispatch($transaction);

        $transaction->refresh();

        $this->assertEquals(Transaction::STATUS_EXPIRED, $transaction->status);
    }

    /** @test */
    public function isSkipUpdateTransactionWhenStatusNotWaiting(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var Campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $campaign->transactions()->create([
            'amount' => 10000,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'status' => Transaction::STATUS_PAID,
        ]);

        /** @var Transaction */
        $transaction = Transaction::first();

        $this->assertEquals(Transaction::STATUS_PAID, $transaction->status);
    }
}
