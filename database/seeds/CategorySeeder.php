<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name' => 'Meat', 'super_category_id' => null],
            ['name' => 'Potato', 'super_category_id' => null],
            ['name' => 'Vegitables', 'super_category_id' => null],
            ['name' => 'Fruit', 'super_category_id' => null],
            ['name' => 'Dairy', 'super_category_id' => null],
            ['name' => 'Beef', 'super_category_id' => 1],
            ['name' => 'Pork', 'super_category_id' => 1],
            ['name' => 'Chicken', 'super_category_id' => 1],
            ['name' => 'Other', 'super_category_id' => 1],
            ['name' => 'Cauliflower', 'super_category_id' => 3],
        ]);
        

    }
}
