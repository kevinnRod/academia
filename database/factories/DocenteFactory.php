<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Docente;
use App\Models\EstadoCivil;
use App\Models\Nivel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docente>
 */
class DocenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Docente::class;

    public function definition(): array
    {
        $estadoCivil = EstadoCivil::all()->random();
        $nivel = Nivel::all()->random();

        return [
            'apellidos' => $this->faker->name(),
            'nombres' => $this->faker->name(),
            'direccion' => $this->faker->sentence(1),
            'idEstadoCivil' => $estadoCivil->idEstadoCivil,
            'telefono' => '987654321',
            'fechaIngreso' => $this->faker->date(),
            'idNivel' => $nivel->idNivel,
            'estado' => '1',
        ];
    }
}
