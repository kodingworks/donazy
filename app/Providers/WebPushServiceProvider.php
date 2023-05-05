<?php

namespace App\Providers;

use App\Channels\WebPushChannel;
use Minishlink\WebPush\WebPush;
use NotificationChannels\WebPush\ReportHandler;
use NotificationChannels\WebPush\ReportHandlerInterface;
use NotificationChannels\WebPush\WebPushServiceProvider as BaseWebPushServiceProvider;

class WebPushServiceProvider extends BaseWebPushServiceProvider
{
    public function register()
    {
        $this->app->when(WebPushChannel::class)
            ->needs(WebPush::class)
            ->give(function () {
                return (new WebPush(
                    $this->webPushAuth(), [], 30, config('webpush.client_options', [])
                ))->setReuseVAPIDHeaders(true);
            });

        $this->app->when(WebPushChannel::class)
            ->needs(ReportHandlerInterface::class)
            ->give(ReportHandler::class);
    }
}
