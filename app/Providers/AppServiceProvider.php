<?php

namespace App\Providers;

use App\Mail\BrevoTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Brevo HTTPS-API mail transport (MAIL_MAILER=brevo)
        Mail::extend('brevo', function (array $config) {
            return new BrevoTransport($config['key'] ?? config('services.brevo.key'));
        });

        // Hosts such as Render terminate HTTPS at a proxy; force https links in production.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
