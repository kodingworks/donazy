<?php

namespace Tests\Feature\Admin\Transactions\Status;

use App\Models\Transaction;
use App\Notifications\TransactionPaid;
use Illuminate\Http\Response;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\Admin\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function isCanUpdate(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::transactions.statuses.update', $transaction), [
                'status' => Transaction::STATUS_PAID,
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $transaction->refresh();

        $this->assertEquals(Transaction::STATUS_PAID, $transaction->status);
    }

    /** @test */
    public function isErrorWhenStatusIsNotExists(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::transactions.statuses.update', $transaction));

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['status']);
    }

    /** @test */
    public function isErrorWhenStatusIsNotInTransactionStatuses(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::transactions.statuses.update', $transaction), [
                'status' => 'some-status',
            ]);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['status']);
    }

    /** @test */
    public function isUpdateCampaignCollectedFundsWhenStatusUpdatedToPaid(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state([
                'amount' => 10000,
                'status' => Transaction::STATUS_WAITING,
            ])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::transactions.statuses.update', $transaction), [
                'status' => Transaction::STATUS_PAID,
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $transaction->refresh();

        $this->assertEquals(Transaction::STATUS_PAID, $transaction->status);
        $this->assertEquals($transaction->total, $transaction->campaign->collected_funds);
    }

    /** @test */
    public function isUpdateCampaignDonorsWhenStatusUpdatedToPaid(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state([
                'amount' => 10000,
                'status' => Transaction::STATUS_WAITING,
            ])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::transactions.statuses.update', $transaction), [
                'status' => Transaction::STATUS_PAID,
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $transaction->refresh();

        $this->assertEquals(Transaction::STATUS_PAID, $transaction->status);
        $this->assertEquals(1, $transaction->campaign->donors);
    }

    /** @test */
    public function isErrorWhenStatusNotWaiting(): void
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state([
                'amount' => 10000,
                'status' => Transaction::STATUS_PAID,
            ])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::transactions.statuses.update', $transaction), [
                'status' => Transaction::STATUS_WAITING,
            ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function isSendEmailTransactionPaidNotificationWhenStatusUpdatedToPai(): void
    {
        Notification::fake();

        /** @var Transaction $transaction */
        $transaction = Transaction::factory()
            ->state(['status' => Transaction::STATUS_WAITING])
            ->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::transactions.statuses.update', $transaction), [
                'status' => Transaction::STATUS_PAID,
            ]);

        $response->assertStatus(Response::HTTP_FOUND);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            TransactionPaid::class,
            function ($notification, $channels, $notifiable) use ($transaction) {
                return in_array($transaction->user_name, $notifiable->routes['mail']) && in_array($transaction->user_email, array_keys($notifiable->routes['mail']));
            }
        );
    }
}
