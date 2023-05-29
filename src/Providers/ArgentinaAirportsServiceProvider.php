<?php

declare(strict_types=1);

namespace Hmreumann\ArgentinaAirports\Providers;

use Hmreumann\ArgentinaAirports\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

final class ArgentinaAirportsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->commands([
            InstallCommand::class,
        ]);
    }
}
