<?php

namespace Database\Factories;

use App\Models\Assistance;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contract;
use App\Models\Worker;

class AssistanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assistance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contract_id' => Contract::all()->random()->id,
            'worker_id' => Worker::all()->random()->id,
            'hoursWorked' => rand(4, 8),
            'assistanceDate' => $this->faker->dateTimeBetween('-1 years', 'now')
        ];
    }
}
