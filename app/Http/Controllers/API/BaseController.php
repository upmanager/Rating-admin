<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Facilities;
use App\Models\Rating;
use App\Models\RatingDetail;

class BaseController extends Controller
{
    //
    public function facilities(Request $request)
    {
        $data = Facilities::select('*')->orderby('name')->get();
        foreach ($data as $key => $value) {
            $value->Manager;
            $value->Rating;
        }
        return response()->json(['success' => true, "data" => $data, 'message' => "login success"], 200);
    }
    public function questions()
    {
        $data = Categories::select('*')->orderby('order')->get();
        foreach ($data as $key => $value) {
            $value->Questions;
        }
        return response()->json(['success' => true, "data" => $data, 'message' => "login success"], 200);
    }
    public function upload(Request $request)
    {
        $type = $request->type;
        if ($request->file('file')) {
            $file = $request->file('file')->store($type, 'public');
            return response()->json(['success' => true, "path" => $file], 200);
        }
        return response()->json(['success' => false], 200);
    }
    public function addRating(Request $request)
    {
        $workerid = $request->workerid;
        $facilityid = $request->facilityid;
        $location = $request->location;
        $ratings = $request->ratings;

        $ratingid = Rating::create([
            'workerid' => $workerid,
            'facilityid' => $facilityid,
            'rating' => 5,
        ])->id;

        RatingDetail::create([
            'ratingid' => $ratingid,
            'res_key' => 'location',
            'res_value' => implode(",", $location),
            'type' => 0
        ]);
        foreach ($ratings as $key => $value) {
            $res_value = $value['match'] == true || $value['match'] == 'true' ? 'true' : implode(",", $value['images']);
            RatingDetail::create([
                'ratingid' => $ratingid,
                'res_key' => 'ratings',
                'res_value' => $res_value,
                'type' => $value['questionid']
            ]);
        }
        return response()->json(['success' => true], 200);
    }
}
