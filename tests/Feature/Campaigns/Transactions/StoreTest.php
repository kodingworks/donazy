<?php

namespace Tests\Feature\Campaigns\Transactions;

use App\Jobs\UpdateExpiredTransaction;
use App\Models\Campaign;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\TransactionWaitingForPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function isErrorWhenValidationNotPassed(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->create();

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]));

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors([
                'amount',
                'name',
                'email',
            ]);
    }

    /** @test */
    public function isErrorWhenCampaignNotPublished(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function isErrorWhenCampaignAlreadyClosed(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->closed()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function isCanBeSaved(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'user_name' => 'Fulan bin Fulan',
            'user_email' => 'fulan@example.com',
            'amount' => 10000,
        ]);
    }

    /** @test */
    public function isCanBeSavedAsAnonymous(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
            'anonymous' => 1
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'user_name' => 'Fulan bin Fulan',
            'user_email' => 'fulan@example.com',
            'amount' => 10000,
            'anonymous' => 1,
        ]);
    }

    /** @test */
    public function isCanBeSavedWithMessage(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
            'message' => 'Ini sebuah message',
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'user_name' => 'Fulan bin Fulan',
            'user_email' => 'fulan@example.com',
            'amount' => 10000,
            'message' => 'Ini sebuah message',
        ]);
    }

    /** @test */
    public function isSavedWithPhone(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
            'phone' => '6281212341234',
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'user_name' => 'Fulan bin Fulan',
            'user_email' => 'fulan@example.com',
            'user_phone' => '6281212341234',
            'amount' => 10000,
        ]);
    }

    /** @test */
    public function hasTransactionCodesCookieWhenSaved(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        /** @var Transaction $transaction */
        $transaction = Transaction::first();

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertCookie('transactionCodes', json_encode([$transaction->code]));
    }

    /** @test */
    public function isAttachTransactionCodesToCookieWhenTransactionCodesCookieAlreadyExists(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        /** @var Transaction $previousTransaction */
        $previousTransaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
        ];

        $response = $this
            ->withCookie('transactionCodes', json_encode([$previousTransaction->code]))
            ->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        /** @var Transaction $newTransaction */
        $newTransaction = Transaction::where('id', '!=', $previousTransaction->id)->first();

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertCookie('transactionCodes', json_encode([$previousTransaction->code, $newTransaction->code]));
    }

    /** @test */
    public function isAttachUserIdToTransactionWhenAlreadyLoggedIn(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $message = $this->faker->text();

        $data = [
            'amount' => 10000,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'message' => $message,
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('transactions', [
            'amount' => 10000,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'message' => $message,
        ]);
    }

    /** @test */
    public function isNotAttachTransactionCodesToCookieWhenAlreadyLoggedIn(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $message = $this->faker->text();

        $data = [
            'amount' => 10000,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'message' => $message,
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response->assertStatus(Response::HTTP_FOUND)
            ->assertCookieMissing('transactionCodes');
    }

    /** @test */
    public function isSendEmailWaitingForPaymentNotification(): void
    {
        Notification::fake();

        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => 'Fulan bin Fulan',
            'email' => 'fulan@example.com',
            'message' => $this->faker->text(),
        ];

        $response = $this->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            TransactionWaitingForPayment::class,
            function ($notification, $channels, $notifiable) {
                return in_array('Fulan bin Fulan', $notifiable->routes['mail']) && in_array('fulan@example.com', array_keys($notifiable->routes['mail']));
            }
        );
    }

    /** @test */
    public function isSavedMetaPayload(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Campaign $campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $message = $this->faker->text();

        $data = [
            'amount' => 10000,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'message' => $message,
            'meta' => json_encode(['var1' => 'value1', 'var2' => 'value2']),
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        /** @var Transaction */
        $transaction = Transaction::first();

        $this->assertTrue(!empty($transaction->meta));
    }

    /** @test */
    public function isDispatchExpiringTime(): void
    {
        Queue::fake();

        /** @var User */
        $user = User::factory()->create();

        /** @var Campaign */
        $campaign = Campaign::factory()
            ->published()
            ->available()
            ->create();

        $data = [
            'amount' => 10000,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('campaigns.transactions.store', ['slug' => $campaign->slug]), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        /** @var Transaction */
        $transaction = Transaction::first();

        Queue::assertPushed(function (UpdateExpiredTransaction $job) use ($transaction) {
            return $job->transaction->id === $transaction->id && $job->delay === Transaction::EXPIRED_TIME_IN_SECONDS;
        });
    }
}
