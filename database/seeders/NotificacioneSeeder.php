<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notificacione;

class NotificacioneSeeder extends Seeder
{
    public function run(): void
    {
        Notificacione::factory()->count(20)->create();
    }
}