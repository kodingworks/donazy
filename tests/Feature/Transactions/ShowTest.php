<?php

namespace Tests\Feature\Transactions;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function isCanBeRendered(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $response = $this
            ->withCookie('transactionCodes', json_encode([$transaction->code]))
            ->get(route('transactions.show', ['code' => $transaction->code]));

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function isErrorWhenTransactionCodesCookieNotExists(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $response = $this->get(route('transactions.show', ['code' => $transaction->code]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function isErrorWhenTransactionCodeNotExistsOnTransactionCodesCookie(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $response = $this
            ->withCookie('transactionCodes', json_encode(['12345']))
            ->get(route('transactions.show', ['code' => $transaction->code]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function isCanBeRenderedWhenUserAuthenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state([
                'user_id' => $user->id,
                'status' => Transaction::STATUS_WAITING,
            ])
            ->create();

        $response = $this
            ->actingAs($user)
            ->get(route('transactions.show', ['code' => $transaction->code]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
