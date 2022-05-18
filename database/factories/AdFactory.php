<?php

namespace Database\Factories\Dealskoo\Adserver\Models;

use Dealskoo\Adserver\Models\Ad;
use Dealskoo\Adserver\Models\AdSpace;
use Dealskoo\Country\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'banner' => $this->faker->imageUrl,
            'link' => $this->faker->url,
            'ad_space_id' => AdSpace::factory()->create(),
            'country_id' => Country::factory()->create(),
            'start_at' => $this->faker->dateTime,
            'end_at' => $this->faker->dateTime
        ];
    }

    public function avaiabled()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->dateTimeBetween('-1 days'),
                'end_at' => $this->faker->dateTimeBetween('now', '+7 days'),
            ];
        });
    }
}
