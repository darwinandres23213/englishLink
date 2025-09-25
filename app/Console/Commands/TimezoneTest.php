<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class TimezoneTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timezone:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test timezone configuration for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Timezone Configuration...');
        $this->line('');
        
        // Información sobre configuración
        $this->info('App Configuration:');
        $this->line('APP_TIMEZONE: ' . config('app.timezone'));
        $this->line('PHP default timezone: ' . date_default_timezone_get());
        $this->line('');
        
        // Fechas de prueba
        $this->info('Current Timestamps:');
        $this->line('now(): ' . now()->format('Y-m-d H:i:s T'));
        $this->line('Carbon::now(): ' . Carbon::now()->format('Y-m-d H:i:s T'));
        $this->line('Carbon::now(config("app.timezone")): ' . Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s T'));
        $this->line('');
        
        // Simulación de datetime-local
        $this->info('Datetime-local simulation:');
        $testDateTime = '2025-07-14T23:48';
        $this->line('Input: ' . $testDateTime);
        
        // Como se estaba guardando antes (problema)
        $parsed1 = Carbon::parse($testDateTime);
        $this->line('Carbon::parse(): ' . $parsed1->format('Y-m-d H:i:s T') . ' (UTC)');
        
        // Como debería guardarse (solución)
        $parsed2 = Carbon::parse($testDateTime)->setTimezone(config('app.timezone'));
        $this->line('With timezone: ' . $parsed2->format('Y-m-d H:i:s T'));
        
        $this->line('');
        $this->info('Test completed!');
        
        return 0;
    }
}
