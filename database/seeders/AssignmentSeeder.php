<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assignment;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assignment::create([
        //     'contract_id'             =>    rand(1, 10),
        //     'worker_id'             =>    rand(1, 20),
        // ]);
        Assignment::factory(20)->create();
    }
}
