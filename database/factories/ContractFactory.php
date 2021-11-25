<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\ContractType;
use App\Models\ContractStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'             =>    $this->faker->catchPhrase,
            'contractAddress'             =>    $this->faker->address,
            'contract_type_id'             =>    ContractType::all()->random()->id,
            'contract_status_id'             =>    ContractStatus::all()->random()->id,
            'startDate'             =>    $this->faker->dateTimeBetween('-1 years', 'now'),
            'endDate'             =>        $this->faker->dateTimeBetween('-1 years', 'now'),
            'totalCost'             =>    rand(1000, 10000),
            'delete'             =>    0
        ];
    }
}
