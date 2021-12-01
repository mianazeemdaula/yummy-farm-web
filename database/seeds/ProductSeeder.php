<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Product::class, 50)->create()->each(function ($p){
            if($p->individual)
                $p->categories()->attach(1);
            else
                $p->categories()->sync([3,5]);
        });
    }
}
