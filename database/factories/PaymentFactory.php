<?php

namespace Database\Factories;

use App\Model;
use App\Models\Contract;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contract_id' => Contract::all()->random()->id,
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'delete' => rand(0, 1),
            'amount' => rand(1000, 10000),
        ];
    }
}
