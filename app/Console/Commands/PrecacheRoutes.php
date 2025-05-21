<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PrecacheRoutes extends Command
{
    protected $signature = 'cache:routes';
    protected $description = 'Pre-cache important routes for faster user experience';

    public function handle()
    {
        $routes = [
            url('/'),
            url('/whats-on?type=schedule'),
            url('/whats-on?type=alphabetical'),
        ];

        $this->info('Pre-caching routes...');

        foreach ($routes as $route) {
            $this->info("Caching: {$route}");

            try {
                $response = Http::get($route);
                $this->info("Status: {$response->status()}");
            } catch (\Exception $e) {
                $this->error("Failed: {$e->getMessage()}");
            }

            sleep(5);
        }

        $this->info('Pre-caching complete!');
    }
}
