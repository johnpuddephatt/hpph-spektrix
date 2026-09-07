<?php

namespace Database\Factories;

use App\Models\Membership;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Membership::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published' => $this->faker->boolean,
            'show_by_booking_path' => $this->faker->boolean,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'long_description' => $this->faker->text,
            'price' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'renewal_price' => $this->faker->regexify('[A-Za-z0-9]{30}'),
        ];
    }
}
