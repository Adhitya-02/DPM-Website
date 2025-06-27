<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load helper functions
        require_once app_path('helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // SSL Fix untuk development environment (untuk Midtrans)
        if (app()->environment('local')) {
            $this->configureSslForDevelopment();
        }
    }

    /**
     * Configure SSL untuk development environment
     */
    private function configureSslForDevelopment(): void
    {
        // Set CURL default options untuk mengatasi SSL error
        $curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
        ];
        
        // Set default context untuk stream
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
            'http' => [
                'timeout' => 60,
                'user_agent' => 'Laravel-Midtrans-Integration/1.0',
            ]
        ]);
        
        libxml_set_streams_context($context);
    }
}