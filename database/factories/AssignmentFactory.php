<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Contract;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contract_id' => Contract::all()->random()->id,
            'worker_id' => Worker::all()->random()->id
        ];
    }
}
