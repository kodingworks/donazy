<?php

namespace App\Notifications;

use App\Channels\WebPushChannel;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;

class TransactionPaid extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Transaction */
    private $transaction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Donasi sudah diterima')
            ->markdown('notifications.transaction-paid', [
                'transaction' => $this->transaction,
            ]);
    }

    /**
     * Get the web push representation of the notification
     *
     * @param mixed $notifiable
     * @return \NotificationChannels\WebPush\WebPushMessage
     */
    public function toWebPush($notifiable)
    {
        return (new WebPushMessage)
            ->title('Donasi sudah diterima')
            ->icon('https://i.ibb.co/F7K52H7/donazy-logo-rounded.png')
            ->body('Terima kasih atas donasi anda.')
            ->data(route('transactions.show', ['code' => $this->transaction->code]))
            ->options(['TTL' => 300]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
