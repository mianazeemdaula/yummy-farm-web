<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::insert([
            ['lang' => 'English'],
            ['lang' => 'Italian'],
            ['lang' => 'Japanese'],
        ]);
    }
}
