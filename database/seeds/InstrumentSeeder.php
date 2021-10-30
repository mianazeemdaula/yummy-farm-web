<?php

use Illuminate\Database\Seeder;
use App\Models\Instrument;
use App\Models\InstrumentCategory;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instrument::insert([
            ['logo' => 'images/piano.png', 'name' => 'Piano'],
            ['logo' => 'images/clarinet.png', 'name' => 'Keyboard'],
            ['logo' => 'images/trumpet.png', 'name' => 'Classical Piano'],
            ['logo' => 'images/guitar.png', 'name' => 'Piano Composition'],
            ['logo' => 'images/saxophone.png', 'name' => 'Jazz Piano'],
            ['logo' => 'images/violin.png', 'name' => 'Pop Piano'],
            ['logo' => 'images/cajon.png', 'name' => 'Rock Piano'],
            ['logo' => 'images/harp.png', 'name' => 'Gospel Piano'],
            ['logo' => 'images/harp.png', 'name' => 'New Age Piano'],
            ['logo' => 'images/harp.png', 'name' => 'ABRSM Exam Prep'],
            ['logo' => 'images/harp.png', 'name' => 'Beginer'],
            ['logo' => 'images/harp.png', 'name' => 'Intermediate'],
            ['logo' => 'images/harp.png', 'name' => 'Advanced'],
            ['logo' => 'images/harp.png', 'name' => 'Grade 1-3'],
            ['logo' => 'images/harp.png', 'name' => 'Grade 4-5'],
            ['logo' => 'images/harp.png', 'name' => 'Grade 6-7'],
            ['logo' => 'images/harp.png', 'name' => 'Grade 8+'],
        ]);
        // $inst = Instrument::find(1);
        // $cats = [
        //     new InstrumentCategory(['name' => 'Classic Piano']),
        //     new InstrumentCategory(['name' => 'Rock Piano']),
        //     new InstrumentCategory(['name' => 'Gospel Piano']),
        //     new InstrumentCategory(['name' => 'Pop Piano']),
        // ];
        // $inst->category()->saveMany($cats);

        // $inst = Instrument::find(2);
        // $cats = [
        //     new InstrumentCategory(['name' => 'A Clarinet']),
        //     new InstrumentCategory(['name' => 'Eb Clarinet']),
        //     new InstrumentCategory(['name' => 'Bass Clarinet']),
        //     new InstrumentCategory(['name' => 'Bb Clarinet']),
        // ];
        // $inst->category()->saveMany($cats);

        // $inst->category()->save(['name' => 'A Clarinet', 'instrument_id', 2]);
        // $inst->category()->save(['name' => 'Eb Clarinet', 'instrument_id', 2]);
        // $inst->category()->save(['name' => 'Bass Clarinet', 'instrument_id', 2]);
        // $inst->category()->save(['name' => 'Bb clarinet,', 'instrument_id', 3]);

    }
}
