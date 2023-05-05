<?php

namespace Tests\Feature\MyTransactions;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('my-transactions.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function isShowTransactions(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Collection */
        $transactions = Transaction::factory(10)
            ->state(['user_id' => $user->id])
            ->create();
        /** @var Transaction */
        $sampleTransaction = $transactions->random();

        $response = $this
            ->actingAs($user)
            ->get(route('my-transactions.index'));

        $response
            ->assertOk()
            ->assertSee($sampleTransaction->campaign->name);
    }

    /** @test */
    public function isShowPaidTransactionTotal(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Transaction */
        $transactions = Transaction::factory(10)
            ->state(['user_id' => $user->id])
            ->create();
        /** @var int */
        $paidTransactionTotal = $transactions
            ->where('status', Transaction::STATUS_PAID)
            ->sum('total');

        $response = $this
            ->actingAs($user)
            ->get(route('my-transactions.index'));

        $response
            ->assertOk()
            ->assertSee(number_format($paidTransactionTotal, 0, ',', '.'));
    }
}
