<?php

namespace Database\Factories;

use App\Models\property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => $this->faker->randomElement(['casa', 'departamento', 'local comercial']),
            'direccion' => $this->faker->address(),
            'precio' => $this->faker->randomFloat(2, 100000, 1000000),
            'descripcion' => $this->faker->paragraph(),
            'estado' => $this->faker->randomElement(['disponible', 'alquilado', 'mantenimiento']),
            'created_at' => now(),
            'updated_at' => now(),
            
        ];
    }
}
