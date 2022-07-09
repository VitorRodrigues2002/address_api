<?php
namespace Database\Factories;

use App\Models\County;
use App\Models\District;
use App\Models\ZipCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZipCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ZipCode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'district_id'   => District::factory(),
            'county_id'     => County::factory(),
            'code_locality' => $this->faker->randomNumber(),
            'name_locality' => $this->faker->name,
            'code_arteria'  => $this->faker->randomNumber(),
            'type_arteria'  => $this->faker->name,
            'prep1'         => $this->faker->name,
            'title_arteria' => $this->faker->name,
            'prep2'         => $this->faker->name,
            'name_arteria'  => $this->faker->name,
            'local_arteria' => $this->faker->name,
            'change'        => $this->faker->name,
            'door'          => $this->faker->name,
            'client'        => $this->faker->name,
            'number'        => $this->faker->numberBetween(1000, 9999),
            'extension'     => $this->faker->numberBetween(100, 999),
            'desig_postal'  => $this->faker->name,
        ];
    }
}
