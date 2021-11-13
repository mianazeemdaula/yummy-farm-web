<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Order::class, 10)->create();
    }
}
