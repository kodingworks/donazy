<?php

namespace Tests\Feature\Services;

use App\Models\Transaction;
use App\Notifications\TransactionPaid;
use App\Services\MootaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MootaServiceTest extends TestCase
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
        $payload = '
            [
                {
                    "account_number": "7562626004",
                    "date": "2021-07-28 20:31:18",
                    "description": "Ibnu Akhir Hidayat",
                    "note": "",
                    "amount": 1570,
                    "type": "CR",
                    "balance": 593094766.04,
                    "updated_at": "2021-07-28 20:31:18",
                    "created_at": "2021-07-28 20:31:18",
                    "mutation_id": "G1ka3lYEbjg",
                    "token": "G1ka3lYEbjg",
                    "bank_id": "DZ4jAO8rkAo",
                    "bank": {
                        "corporate_id": null,
                        "username": "15395516-10",
                        "atas_nama": "Yayasan Cahaya Sunnah (SIP)",
                        "balance": "629660326.04",
                        "account_number": "7562626004",
                        "bank_type": "bsi",
                        "login_retry": 0,
                        "date_from": "2021-07-28 00:00:00",
                        "date_to": "2021-07-28 00:00:00",
                        "meta": {
                            "browser_session_id": "d516a39f00cd619324793ba2211eae23b5cffeae5b7f8699f35428304a24566c"
                        },
                        "interval_refresh": 15,
                        "next_queue": "2021-07-28 20:46:18",
                        "is_active": true,
                        "in_queue": 0,
                        "in_progress": 0,
                        "recurred_at": "2021-07-29 20:26:24",
                        "created_at": "2021-07-28 20:26:24",
                        "token": "DZ4jAO8rkAo",
                        "bank_id": "DZ4jAO8rkAo",
                        "label": "BSI",
                        "last_update": "2021-07-28T13:31:18.000000Z"
                    }
                }
            ]
        ';

        /** @var MootaService */
        $mootaService = new MootaService($payload);

        $this->assertInstanceOf(MootaService::class, $mootaService);
        $this->assertObjectHasAttribute('mutations', $mootaService);
    }

    /** @test */
    public function isSaveMutation(): void
    {
        $payload = '
            [
                {
                    "account_number": "7562626004",
                    "date": "2021-07-28 20:31:18",
                    "description": "Ibnu Akhir Hidayat",
                    "note": "",
                    "amount": 1570,
                    "type": "CR",
                    "balance": 593094766.04,
                    "updated_at": "2021-07-28 20:31:18",
                    "created_at": "2021-07-28 20:31:18",
                    "mutation_id": "G1ka3lYEbjg",
                    "token": "G1ka3lYEbjg",
                    "bank_id": "DZ4jAO8rkAo",
                    "bank": {
                        "corporate_id": null,
                        "username": "15395516-10",
                        "atas_nama": "Yayasan Cahaya Sunnah (SIP)",
                        "balance": "629660326.04",
                        "account_number": "7562626004",
                        "bank_type": "bsi",
                        "login_retry": 0,
                        "date_from": "2021-07-28 00:00:00",
                        "date_to": "2021-07-28 00:00:00",
                        "meta": {
                            "browser_session_id": "d516a39f00cd619324793ba2211eae23b5cffeae5b7f8699f35428304a24566c"
                        },
                        "interval_refresh": 15,
                        "next_queue": "2021-07-28 20:46:18",
                        "is_active": true,
                        "in_queue": 0,
                        "in_progress": 0,
                        "recurred_at": "2021-07-29 20:26:24",
                        "created_at": "2021-07-28 20:26:24",
                        "token": "DZ4jAO8rkAo",
                        "bank_id": "DZ4jAO8rkAo",
                        "label": "BSI",
                        "last_update": "2021-07-28T13:31:18.000000Z"
                    }
                }
            ]
        ';

        /** @var MootaService */
        $mootaService = new MootaService($payload);
        $mootaService->save();

        $this->assertDatabaseHas('mutations', [
            'account_number' => '7562626004',
            'account_holder_name' => 'Yayasan Cahaya Sunnah (SIP)',
            'bank_name' => 'BSI',
            'received_at' => '2021-07-28 20:31:18',
            'type' => 'CREDIT',
            'description' => 'Ibnu Akhir Hidayat',
            'amount' => 1570,
            'balance' => 593094766,
        ]);
    }

    /** @test */
    public function isUpdateTransactionStatusBasedOnAmount(): void
    {
        /** @var Transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $payload = '
            [
                {
                    "account_number": "7562626004",
                    "date": "2021-07-28 20:31:18",
                    "description": "Ibnu Akhir Hidayat",
                    "note": "",
                    "amount": ' . $transaction->total . ',
                    "type": "CR",
                    "balance": 593094766.04,
                    "updated_at": "2021-07-28 20:31:18",
                    "created_at": "2021-07-28 20:31:18",
                    "mutation_id": "G1ka3lYEbjg",
                    "token": "G1ka3lYEbjg",
                    "bank_id": "DZ4jAO8rkAo",
                    "bank": {
                        "corporate_id": null,
                        "username": "15395516-10",
                        "atas_nama": "Yayasan Cahaya Sunnah (SIP)",
                        "balance": "629660326.04",
                        "account_number": "7562626004",
                        "bank_type": "bsi",
                        "login_retry": 0,
                        "date_from": "2021-07-28 00:00:00",
                        "date_to": "2021-07-28 00:00:00",
                        "meta": {
                            "browser_session_id": "d516a39f00cd619324793ba2211eae23b5cffeae5b7f8699f35428304a24566c"
                        },
                        "interval_refresh": 15,
                        "next_queue": "2021-07-28 20:46:18",
                        "is_active": true,
                        "in_queue": 0,
                        "in_progress": 0,
                        "recurred_at": "2021-07-29 20:26:24",
                        "created_at": "2021-07-28 20:26:24",
                        "token": "DZ4jAO8rkAo",
                        "bank_id": "DZ4jAO8rkAo",
                        "label": "BSI",
                        "last_update": "2021-07-28T13:31:18.000000Z"
                    }
                }
            ]
        ';

        /** @var MootaService */
        $mootaService = new MootaService($payload);
        $mootaService->save();

        $transaction->refresh();

        $this->assertEquals(Transaction::STATUS_PAID, $transaction->status);
    }

    /** @test */
    public function isValidateSignatureWorkingCorrectly(): void
    {
        Config::set('services.moota.secret', 'q8D3rHmv');

        $signature = '9250dfe306e7e000d58df4daacfc2646167f7fa71a21f6f17b3aa6625294bbbe';
        $payload = '[{"id":697,"bank_id":"jyHs","account_number":4464093,"bank_type":"bca","date":"2021-07-28 22:50:19","amount":"10000","description":"cek","type":"CR","balance":1900000}]';

        /** @var MootaService */
        $mootaService = new MootaService($payload);

        $this->assertTrue($mootaService->validateSignature($signature));
    }

    /** @test */
    public function isSendEmailTransactionPaidNotification(): void
    {
        Notification::fake();

        /** @var Transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $payload = '
            [
                {
                    "account_number": "7562626004",
                    "date": "2021-07-28 20:31:18",
                    "description": "Ibnu Akhir Hidayat",
                    "note": "",
                    "amount": ' . $transaction->total . ',
                    "type": "CR",
                    "balance": 593094766.04,
                    "updated_at": "2021-07-28 20:31:18",
                    "created_at": "2021-07-28 20:31:18",
                    "mutation_id": "G1ka3lYEbjg",
                    "token": "G1ka3lYEbjg",
                    "bank_id": "DZ4jAO8rkAo",
                    "bank": {
                        "corporate_id": null,
                        "username": "15395516-10",
                        "atas_nama": "Yayasan Cahaya Sunnah (SIP)",
                        "balance": "629660326.04",
                        "account_number": "7562626004",
                        "bank_type": "bsi",
                        "login_retry": 0,
                        "date_from": "2021-07-28 00:00:00",
                        "date_to": "2021-07-28 00:00:00",
                        "meta": {
                            "browser_session_id": "d516a39f00cd619324793ba2211eae23b5cffeae5b7f8699f35428304a24566c"
                        },
                        "interval_refresh": 15,
                        "next_queue": "2021-07-28 20:46:18",
                        "is_active": true,
                        "in_queue": 0,
                        "in_progress": 0,
                        "recurred_at": "2021-07-29 20:26:24",
                        "created_at": "2021-07-28 20:26:24",
                        "token": "DZ4jAO8rkAo",
                        "bank_id": "DZ4jAO8rkAo",
                        "label": "BSI",
                        "last_update": "2021-07-28T13:31:18.000000Z"
                    }
                }
            ]
        ';

        /** @var MootaService */
        $mootaService = new MootaService($payload);
        $mootaService->save();

        Notification::assertSentTo(
            new AnonymousNotifiable,
            TransactionPaid::class,
            function ($notification, $channels, $notifiable) use ($transaction) {
                return in_array($transaction->user_name, $notifiable->routes['mail']) && in_array($transaction->user_email, array_keys($notifiable->routes['mail']));
            }
        );
    }
}
