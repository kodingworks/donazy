<?php

namespace Tests\Feature\Commands;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateExpiredTransactionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake(['eloquent.created: ' . Transaction::class]);
    }

    /** @test */
    public function isUpdateTransactionsWhereStatusIsWaitingMoreThan1Day(): void
    {
        Transaction::factory(10)
            ->state([
                'status' => Transaction::STATUS_WAITING,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ])
            ->create();

        $this->assertDatabaseMissing('transactions', ['status' => Transaction::STATUS_EXPIRED]);

        $this->artisan('expired-transactions:update');

        $this->assertDatabaseMissing('transactions', ['status' => Transaction::STATUS_WAITING]);
    }
}
