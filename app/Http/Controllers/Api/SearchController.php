<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\User;
use Carbon\Carbon;

class SearchController extends Controller
{
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
