<?php

namespace Database\Factories;

use App\Models\Worker;
use App\Models\WorkerType;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'names' => $this->faker->firstName,
            'surnames' => $this->faker->lastName,
            'identificationDocument' => $this->faker->ssn,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'nationality' => $this->faker->country,
            'workerAddress' => $this->faker->streetAddress,
            'phone' => $this->faker->phoneNumber,
            'registrationDate' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'worker_type_id' => WorkerType::all()->random()->id,
            'hourly' => rand(120, 250),
        ];
    }
}
