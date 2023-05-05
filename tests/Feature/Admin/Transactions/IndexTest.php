<?php

namespace Tests\Feature\Admin\Transactions;

use App\Exports\Admin\TransactionsExport;
use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Tests\Feature\Admin\TestCase;

class IndexTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function isRenderAView(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::transactions.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('admin::transactions.index');
    }

    /** @test */
    public function isShowTransactions(): void
    {
        $campaign = Campaign::factory()->published()->create();

        $transaction = Transaction::create([
            'campaign_id' => $campaign->id,
            'user_name' => 'Fulan bin Fulan',
            'user_email' => 'fulan@example.com',
            'message' => $this->faker->text(100),
            'amount' => 100000,
        ]);

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::transactions.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertSee($transaction->id)
            ->assertSee($transaction->code)
            ->assertSee($campaign->name)
            ->assertSee($transaction->user_name)
            ->assertSee(number_format($transaction->total, 0, ',', '.'))
            ->assertSee($transaction->status);
    }

    /** @test */
    public function isCanExport(): void
    {
        Excel::fake();

        /** @var Campaign */
        $campaign = Campaign::factory()->create();

        $transactions = [];

        for ($i = 0; $i < 30; $i++) {
            $transactions[] = [
                'user_name' => $this->faker->lastName(),
                'user_email' => $this->faker->freeEmail(),
                'message' => $this->faker->text(100),
                'amount' => str_pad(random_int(1000, 9999999), 7, 0, STR_PAD_LEFT),
                'status' => $this->faker->randomElement(Transaction::STATUSES),
            ];
        }

        $campaign->transactions()->createMany($transactions);

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::transactions.index', ['action' => 'export']));

        $response->assertStatus(Response::HTTP_OK);

        Excel::assertDownloaded('transactions.xlsx', function (TransactionsExport $export) use ($campaign) {
            return $export->query()->get()->contains('campaign_id', $campaign->id);
        });
    }
}
