<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Minishlink\WebPush\Subscription;
use NotificationChannels\WebPush\WebPushChannel as BaseWebPushChannel;

class WebPushChannel extends BaseWebPushChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification): void
    {
        $rawSubscription = $notifiable->routeNotificationFor(self::class, $notification);

        if (empty($rawSubscription)) {
            return;
        }

        $subscription = json_decode($rawSubscription, true);

        $message = $notification->toWebPush($notifiable, $notification);
        $payload = json_encode($message->toArray());
        $options = $message->getOptions();

        $this->webPush->sendOneNotification(new Subscription(
            $subscription['endpoint'],
            $subscription['keys']['p256dh'],
            $subscription['keys']['auth'],
        ), $payload, $options);
    }
}
