<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediosPago;
use App\Models\Estado;

class MediosPagoSeeder extends Seeder{
    
    public function run(): void{
        // Verificar que existan estados de MedioPago
        if (Estado::whereHas('tipoEstado', function($q) {
            $q->where('nombre_tipo_estado', 'MedioPago');
        })->count() > 0) {
            
            $estadoActivo = Estado::whereHas('tipoEstado', function($q) {
                $q->where('nombre_tipo_estado', 'MedioPago');
            })->where('nombre_estado', 'Activo')->first();

            $mediosPago = [
                ['nombre' => 'Tarjeta de Débito', 'descripcion' => 'Pago directo desde cuenta bancaria'],
                ['nombre' => 'Tarjeta de Crédito', 'descripcion' => 'Pago con línea de crédito'],
                ['nombre' => 'Transferencia Bancaria', 'descripcion' => 'Transferencia electrónica'],
                ['nombre' => 'Efectivo', 'descripcion' => 'Pago en dinero físico'],
                ['nombre' => 'PayPal', 'descripcion' => 'Plataforma de pagos online'],
                ['nombre' => 'MercadoPago', 'descripcion' => 'Procesador de pagos digital'],
                ['nombre' => 'Cheque', 'descripcion' => 'Orden de pago bancaria'],
                ['nombre' => 'Criptomoneda', 'descripcion' => 'Moneda digital descentralizada'],
            ];

            foreach ($mediosPago as $medio) {
                MediosPago::create([
                    'nombre' => $medio['nombre'],
                    'descripcion' => $medio['descripcion'],
                    'estado_id' => $estadoActivo->id_estado,
                ]);
            }
        } else {
            $this->command->warn('No se pueden crear medios de pago: faltan estados de MedioPago');
        }
    }
    
    /*public function run(): void{
        $nombres = [
            'Tarjeta de Débito',
            'Tarjeta de Crédito',
            'Transferencia Bancaria',
            'Efectivo',
            'PayPal',
            'MercadoPago',
            'Cheque',
            'Criptomoneda',
            // ...agrega más si quieres
        ];

        foreach ($nombres as $nombre) {
            MediosPago::create([
                'nombre' => $nombre,
                'descripcion' => fake()->sentence(),
                'activo' => true,
            ]);
        }
    }*/


    /*public function run(): void{
        MediosPago::factory()->count(444)->create();
    }*/
}