<?php

namespace Tests\Feature\Services;

use App\Models\Transaction;
use App\Notifications\TransactionPaid;
use App\Services\MutasiBankService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MutasiBankServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake(['eloquent.created: ' . Transaction::class]);
    }

    /** @test */
    public function isInstantiatedCorrectly(): void
    {
        $payload = json_decode('{
            "api_key":"UmRTOGQ1ckU3QUY4c3VidnBCaFYxbzI4djR5MEo2YVFud3B2NTNrUkpZRjFCSG76e115db7cdVZT3Z6MU51YmZhMnAy5b",
            "account_id": 12,
            "module": "bsi",
            "account_name": "Yayasan Cahaya Sunnah SIP",
            "account_number": "7562626004",
            "balance": 10000000,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": 30097,
                "balance": 427099
            }, {
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  JONI            TO PT AMANAH KARYA",
                "type": "DB",
                "amount": 20002,
                "balance": 429099
            }]
        }', true);

        $mutasiBankService = new MutasiBankService($payload);

        $this->assertInstanceOf(MutasiBankService::class, $mutasiBankService);
    }

    /** @test */
    public function isUpdateTransactions(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $payload = json_decode('{
            "api_key":"UmRTOGQ1ckU3QUY4c3VidnBCaFYxbzI4djR5MEo2YVFud3B2NTNrUkpZRjFCSG76e115db7cdVZT3Z6MU51YmZhMnAy5b",
            "account_id": 12,
            "module": "bsi",
            "account_name": "Yayasan Cahaya Sunnah SIP",
            "account_number": "7562626004",
            "balance": 10000000,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": '. $transaction->total .' ,
                "balance": 427099
            }]
        }', true);

        $mutasiBankService = new MutasiBankService($payload);

        $mutasiBankService->save();

        $transaction->refresh();

        $this->assertEquals(Transaction::STATUS_PAID, $transaction->status);
    }

    /** @test */
    public function isSaveMutation(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $payload = json_decode('{
            "api_key":"UmRTOGQ1ckU3QUY4c3VidnBCaFYxbzI4djR5MEo2YVFud3B2NTNrUkpZRjFCSG76e115db7cdVZT3Z6MU51YmZhMnAy5b",
            "account_id": 12,
            "module": "bsi",
            "account_name": "Yayasan Cahaya Sunnah SIP",
            "account_number": "7562626004",
            "balance": 10000000,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": '. $transaction->total .' ,
                "balance": 427099
            }]
        }', true);

        $mutasiBankService = new MutasiBankService($payload);

        $mutasiBankService->save();

        $this->assertDatabaseHas('mutations', [
            'account_number' => '7562626004',
            'account_holder_name' => 'Yayasan Cahaya Sunnah SIP',
            'bank_name' => 'BSI',
            'received_at' => '2018-08-10 00:00:00',
            'description' => 'TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA',
            'amount' => $transaction->total,
            'balance' => 427099,
        ]);
    }

    /** @test */
    public function isSendEmailTransactionPaidNotification(): void
    {
        Notification::fake();

        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $payload = json_decode('{
            "api_key":"UmRTOGQ1ckU3QUY4c3VidnBCaFYxbzI4djR5MEo2YVFud3B2NTNrUkpZRjFCSG76e115db7cdVZT3Z6MU51YmZhMnAy5b",
            "account_id": 12,
            "module": "bsi",
            "account_name": "Yayasan Cahaya Sunnah SIP",
            "account_number": "7562626004",
            "balance": 10000000,
            "data_mutasi": [{
                "transaction_date": "2018-08-10 00:00:00",
                "description": "TRANSFER EDC  MUHLISIN        TO PT AMANAH KARYA",
                "type": "CR",
                "amount": '. $transaction->total .' ,
                "balance": 427099
            }]
        }', true);

        $mutasiBankService = new MutasiBankService($payload);

        $mutasiBankService->save();

        Notification::assertSentTo(
            new AnonymousNotifiable,
            TransactionPaid::class,
            function ($notification, $channels, $notifiable) use ($transaction) {
                return in_array($transaction->user_name, $notifiable->routes['mail']) && in_array($transaction->user_email, array_keys($notifiable->routes['mail']));
            }
        );
    }
}
