<?php

namespace App\Notifications;

use App\Channels\WebPushChannel;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Services\PaymentMethodService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;

class TransactionWaitingForPayment extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Transaction */
    private $transaction;

    /** @var PaymentMethod */
    private $paymentMethod;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->paymentMethod = (new PaymentMethodService())->getPaymentMethod();
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
            ->subject('Donasi sedang menunggu pembayaran')
            ->markdown('notifications.transaction-waiting-for-payment', [
                'transaction' => $this->transaction,
                'paymentMethod' => $this->paymentMethod,
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
            ->title('Donasi sedang menunggu pembayaran')
            ->icon('https://i.ibb.co/F7K52H7/donazy-logo-rounded.png')
            ->body('Segera salurkan donasi pilihan anda.')
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
