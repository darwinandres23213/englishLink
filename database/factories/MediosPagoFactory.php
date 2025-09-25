<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediosPagoFactory extends Factory
{
    protected static $nombres = [
        'Efectivo',
        'Tarjeta de Crédito',
        'Tarjeta de Débito',
        'Transferencia Bancaria',
        'PayPal',
        'Criptomonedas',
    ];

    public function definition(): array
    {
        // Toma un nombre único de la lista y lo elimina para evitar duplicados
        $nombre = array_shift(self::$nombres);

        return [
            'nombre' => $nombre ?? $this->faker->unique()->word(),
            'descripcion' => $this->faker->sentence(),
            'activo' => 1,
        ];
    }
}

/*class MediosPagoFactory extends Factory{
    public function definition(): array{
        return [
            'nombre' => $this->faker->randomElement([
                'Efectivo',
                'Tarjeta de Crédito',
                'Tarjeta de Débito',
                'Transferencia Bancaria',
                'PayPal',
                'Criptomonedas',
            ]),
            'descripcion' => $this->faker->sentence(),
            'activo' => 1,
        ];
    }
}*/