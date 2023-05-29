<?php

namespace Hmreumann\ArgentinaAirports\Tests;

use Hmreumann\ArgentinaAirports\Actions\GetAirportsData;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;

class ArgentinaAirportsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Hmreumann\ArgentinaAirports\Providers\ArgentinaAirportsServiceProvider::class,
        ];
    }

    /**
     * @covers \Hmreumann\ArgentinaAirports\database\migrations\2023_05_28_181529_create_airports_table.php
     */
    public function test_migration()
    {
        $this->artisan('migrate');

        $this->assertTrue(Schema::hasTable('airports'));
    }

    /**
     * @covers \Hmreumann\ArgentinaAirports\Console\InstallCommand
     */
    public function test_install_command()
    {
        $this->artisan('migrate');

        $this->artisan('argentina-airports:import')->assertExitCode(0);

        $this->assertDatabaseCount('airports', 693);
    }

    /**
     * @covers \Hmreumann\ArgentinaAirports\Console\InstallCommand
     */
    public function test_install_command_without_migration()
    {
        $this->artisan('argentina-airports:import')->assertExitCode(0);
    }

    /**
     * @covers \Hmreumann\ArgentinaAirports\Actions\GetAirportsData
     */
    public function test_get_airports_data_action()
    {
        $data = (new GetAirportsData)->execute();

        $this->assertTrue(is_array($data));
    }
}
