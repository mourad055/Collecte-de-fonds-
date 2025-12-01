<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'nom_cli' => $this->faker->lastName(),
            'prenom_cli' => $this->faker->firstName(),
            'tel_cli' => $this->faker->phoneNumber(),
            'adresse_cli' => $this->faker->address(),
            'solde_cli' => $this->faker->randomFloat(2, 0, 100000),
        ];
    }
}