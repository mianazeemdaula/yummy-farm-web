<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Lession;
use Carbon\Carbon;
use App\Models\Notifications;
use App\Helpers\Fcm;
class LessionNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lession:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $from = Carbon::now()->addMinutes(15);
        $to = Carbon::now()->addMinutes(45);
        $lessions = Lession::where('status', '=' ,'approved')
        ->where('start_at','>=', $from)->where('end_at', '<=', $to)
        ->get();
        foreach ($lessions as $lession) {
            $startTime = Carbon::parse($lession->start_at);
            $minutes = Carbon::now()->diffInMinutes($startTime);
            $notification = new Notifications();
            $notification->user_id = $lession->tutor_id;
            $notification->title = "Next lesson in less than ${minutes} min";
            $notification->body = 'Student: '.$lession->student->name;
            $notification->notification_time = Carbon::parse($lession->start_at, $lession->tutor->time_zone)->setTimezone('UTC');
            $notification->data = json_encode(['id' => $lession->id, 'type' => 'lession']);
            $notification->save();
            Fcm::sendNotification($notification);

            $notification = new Notifications();
            $notification->user_id = $lession->student_id;
            $notification->title = "Next lesson in less than ${minutes} min";
            $notification->body = 'Tutor: '.$lession->tutor->name;
            $notification->notification_time = Carbon::parse($lession->start_at, $lession->student->time_zone)->setTimezone('UTC');
            $notification->data = json_encode(['id' => $lession->id, 'type' => 'lession']);
            $notification->save();
            Fcm::sendNotification($notification);
        }
        $this->info('Schedule Notification sent ');
    }
}
