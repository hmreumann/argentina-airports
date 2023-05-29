<?php

namespace Hmreumann\ArgentinaAirports\Console;

use Hmreumann\ArgentinaAirports\Actions\GetAirportsData;
use Hmreumann\ArgentinaAirports\Models\Airport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class InstallCommand extends Command
{
    protected $signature = 'argentina-airports:import';

    protected $description = 'Import the airports from Argentina to the airports table.';

    public function handle(GetAirportsData $getAirportsData)
    {
        // Check the airports table exists
        if(! Schema::hasTable('airports')){
            $this->info('First, run php artisan migrate in order to create the airports table.');
            return;
        }

        $airportsData = $getAirportsData->execute();

        $progressBar = $this->output->createProgressBar(count($airportsData));
        $progressBar->start();

        foreach($airportsData as $airport)
        {
            Airport::firstOrCreate($airport);

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->info('Argentina Airports package installed successfully!');

    }
}
