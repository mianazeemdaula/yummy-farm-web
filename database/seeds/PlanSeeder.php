<?php

use Illuminate\Database\Seeder;
use App\Models\Plan;
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s1 = Plan::create([
            'name' => 'Monthly',
        ]);

        $s2 = Plan::create([
            'name' => 'Bi-Annually',
        ]);
    }
}
