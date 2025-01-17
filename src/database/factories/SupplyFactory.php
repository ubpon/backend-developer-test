<?php

namespace Database\Factories;

use App\Models\Martian;
use App\Support\SupplySupport;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = SupplySupport::allowedSupplies();

        $martian = Martian::factory()->create();

        $name = $this->faker->randomElement(array_keys($data));

        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
            'quantity' => rand(100, 1000),
            'points' => $data[$name],
            'status' => rand(0, 1),
            'martian_id' => $martian->id
        ];
    }
}
