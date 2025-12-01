<?php

namespace Database\Factories;

use App\Models\Collecteur;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollecteurFactory extends Factory
{
    protected $model = Collecteur::class;

    public function definition()
    {
        return [
            'nom_collect' => $this->faker->lastName(),
            'prenom_collect' => $this->faker->firstName(),
            'tel_collect' => $this->faker->phoneNumber(),
            'zone_collect' => $this->faker->city(),
        ];
    }
}