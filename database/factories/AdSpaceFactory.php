<?php

namespace Database\Factories\Dealskoo\Adserver\Models;

use Dealskoo\Adserver\Models\AdSpace;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdSpaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdSpace::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->slug,
            'description' => $this->faker->text,
        ];
    }
}
