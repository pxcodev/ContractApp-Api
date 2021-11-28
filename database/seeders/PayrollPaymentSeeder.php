<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayrollPayment;

class PayrollPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PayrollPayment::factory(10)->create();
    }
}
