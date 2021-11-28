<?php

namespace Database\Factories;

use App\Model;
use App\Models\Contract;
use App\Models\PaymentMethod;
use App\Models\PayrollPayment;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollPaymentFactory extends Factory
{
    protected $model = PayrollPayment::class;

    public function definition(): array
    {
        return [
            'contract_id' => Contract::all()->random()->id,
            'worker_id' => Worker::all()->random()->id,
            'paidHours' => rand(4, 8),
            'amount' => rand(1000, 10000),
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'delete' => rand(0, 1),
            'payment_method_id' => PaymentMethod::all()->random()->id,
        ];
    }
}
