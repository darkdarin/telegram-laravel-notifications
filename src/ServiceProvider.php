<?php

namespace DarkDarin\TelegramNotification;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider as DefaultServiceProvider;

class ServiceProvider extends DefaultServiceProvider
{
    public function boot(): void
    {
        Notification::extend('telegram', fn(Container $app) => $app->make(TelegramChannel::class));
    }
}
