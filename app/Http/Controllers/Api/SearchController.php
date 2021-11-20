<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\User;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class SearchController extends Controller
{

    public function searchSeller(Request $request)
    {
        $users = User::query();
        if($request->has('lat') && $request->has('lng')){
            $point = new Point($request->lat, $request->lng);
            $users = $users->distanceSphere('location', $point, 5000);
        }
        $users = $users->where('role','seller')->get();
        return response()->json($users);
    }

    public function searchByName(Request $request)
    {
        $text = $request->text;
        $data = [];
        $data['tutors'] =  User::with(['tutorRating', 'tutorToughtHours', 'tutorCountReviews', 'tutorVideos', 'tutorTimes' => function($q){
            $q->where('from_time', '>=', Carbon::now());
            $q->where('booked', false);
        }, 'instruments','userable'])->whereHasMorph('userable', Tutor::class, function($a){
            $a->where('in_search', false);
        })->where('name','like',"%${text}%")->get();

        $data['intruments'] = Instrument::where('name','like',"%${text}%")->get();
        return response()->json(['data' => $data]);
    }
}
