<?php

namespace Tests\Feature\Webhook;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MutasiBankTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake(['eloquent.created: ' . Transaction::class]);
    }

    /** @test */
    public function isUpdatedTransactionStatus(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $payload = json_decode('{
            "api_key":"' . Config::get('services.mutasibank.apikey') . '",
            "account_id": 12,
            "module": "bsi",
            "account_name": "Yayasan Cahaya Sunnah SIP",
            "account_number": "7562626004",
            "balance": 10000000,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": ' . $transaction->total . ' ,
                "balance": 427099
            }]
        }', true);

        $response = $this->postJson('/webhook/mutasibank', $payload);

        $response->assertStatus(Response::HTTP_OK);

        $transaction->refresh();

        $this->assertEquals(Transaction::STATUS_PAID, $transaction->status);
    }

    /** @test */
    public function isErrorWhenApiKeyNotExists(): void
    {
        $payload = json_decode('{
            "account_id": 12,
            "module": "bsi",
            "account_name": "Yayasan Cahaya Sunnah SIP",
            "account_number": "7562626004",
            "balance": 10000000,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": 200000,
                "balance": 427099
            }]
        }', true);

        $response = $this->postJson('/webhook/mutasibank', $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function isErrorWhenApiKeyInvalid(): void
    {
        $payload = json_decode('{
            "api_key": "1234",
            "account_id": 12,
            "module": "bsi",
            "account_name": "Yayasan Cahaya Sunnah SIP",
            "account_number": "7562626004",
            "balance": 10000000,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": 200000,
                "balance": 427099
            }]
        }', true);

        $response = $this->postJson('/webhook/mutasibank', $payload);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
