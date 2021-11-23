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

    /*
ProductDetail 
 ProductSpecies 
 ProductBio (if search is ‘bio’: give the results of fields where bio-label is ja) 
 ProductGrassfed (If search is (gras’ or ‘grasgevoederd’: give the results where the field contains ja) 
 ProductLifestyle 
 ProductPieces 
 ProductName 
 ProductContent 
 ProductCategory


    */
    public function searchSeller(Request $request)
    {
        // \DB::enableQueryLog();
        $sellers = User::query();
        if($request->has('text')){
            $text = $request->text;
            $sellers = User::search($text);
            $sellers->orWhereHas('products', function($q) use($text){
                $q->where('species', 'like', '%'.$text.'%');
                $q->orWhere('description', 'like', '%'.$text.'%');
                $q->orWhere('life_style', 'like', '%'.$text.'%');
                $q->orWhere('name', 'like', '%'.$text.'%');
                $q->orWhere('extra_info', 'like', '%'.$text.'%');
                $q->orWhereHas('categories', function($qc) use($text){
                    $qc->where('name', 'like', '%'.$text.'%');
                });
                if (strpos($text, 'bio') !== false) {
                    $q->orWhere('bio', true);
                }
            });
        }
        if($request->has('lat') && $request->has('lng')){
            $point = new Point($request->lat, $request->lng);
            $sellers->distanceSphere('location', $point, 5000);
        }
        $sellers = $sellers->where('role','seller')->whereNotNull('location')->get();
        // return \DB::getQueryLog();
        return response()->json($sellers);
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
