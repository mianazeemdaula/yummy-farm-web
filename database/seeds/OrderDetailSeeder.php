<?php

use Illuminate\Database\Seeder;
class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\OrderDetail::class, 50)->create();
    }
}
