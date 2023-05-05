<?php

namespace Tests\Feature\Webhook;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MootaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake(['eloquent.created: ' . Transaction::class]);
    }

    /** @test */
    public function isTerminateWhenSignatureIsInvalid(): void
    {
        $jsonPayload = '[{"id":697,"bank_id":"jyHs","account_number":4464093,"bank_type":"bca","date":"2021-07-28 22:50:19","amount":"10000","description":"cek","type":"CR","balance":1900000}]';
        $payload = json_decode($jsonPayload, true);
        $response = $this->postJson('/webhook/moota', $payload, [
            'signature' => '9250dfe306e7e000d58df4daacfc2646167f7fa71a21f6f17b3aa6625294bbbe',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
