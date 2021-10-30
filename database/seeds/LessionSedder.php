<?php

use Illuminate\Database\Seeder;
use App\Models\Lession;
use App\Models\LessionLogs;
use App\Models\Review;
use Carbon\Carbon;
class LessionSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lession::insert([
            ['instrument_id' => 1, 'student_id' => 5, 'tutor_id' => 3, 'lession_duration' => 45, 'start_at' => Carbon::now(), 'end_at' => Carbon::now()->addMinutes(30)],
            ['instrument_id' => 3, 'student_id' => 5, 'tutor_id' => 4, 'lession_duration' => 45,'start_at' => Carbon::now(), 'end_at' => Carbon::now()->addMinutes(30)],
            ['instrument_id' => 2, 'student_id' => 5, 'tutor_id' => 3,'lession_duration' => 45,'start_at' => Carbon::now(), 'end_at' => Carbon::now()->addMinutes(30)],
        ]);

        Review::insert([
            ['rating' => 4, 'comment' => 'very low quality', 'lession_id' => 1 ],
            ['rating' => 3.5, 'comment' => 'very low quality', 'lession_id' => 1 ],
            ['rating' => 4.5, 'comment' => 'Bad but good', 'lession_id' => 2 ],
            ['rating' => 3.5, 'comment' => 'Good Communication', 'lession_id' => 3 ],
            ['rating' => 5, 'comment' => 'Impressive teacher', 'lession_id' => 3 ],
        ]);

        LessionLogs::insert([
            ['lession_id' => 1, 'start_time' => Carbon::now(), 'end_time' => Carbon::now()->addMinutes(30)],
            ['lession_id' => 1, 'start_time' => Carbon::now(), 'end_time' => Carbon::now()->addMinutes(25)],
        ]);
    }
}
