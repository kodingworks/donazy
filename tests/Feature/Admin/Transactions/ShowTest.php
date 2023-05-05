<?php

namespace Tests\Feature\Admin\Transactions;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class ShowTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function isShowTransactionDetail(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->published()->create();

        /** @var Transaction $transaction */
        $transaction = Transaction::create([
            'campaign_id' => $campaign->value('id'),
            'user_name' => 'Fulan bin Fulan',
            'user_email' => 'fulan@example.com',
            'message' => $this->faker->text(100),
            'amount' => 100000,
        ]);

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::transactions.show', $transaction));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($transaction->code)
            ->assertSee($transaction->campaign->name)
            ->assertSee($transaction->user_name)
            ->assertSee($transaction->message)
            ->assertSee($transaction->unique_code)
            ->assertSee(number_format($transaction->amount, 0, ',', '.'))
            ->assertSee(number_format($transaction->total, 0, ',', '.'))
            ->assertSee($transaction->status);
    }
}
