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
        $userid = $request->userid;
        $data = Facilities::select('*')->orderby('name')->get();
        $res_data = [];
        foreach ($data as $key => $value) {
            $value->Manager;
            $value->Rating;

            $ismatch = false;
            $offices = $value->Offices;
            if ($offices == null || count($offices) <= 0) $ismatch = false;
            else {
                foreach ($offices as $office) {
                    $users = $office->UserDetails;
                    if ($users == null || count($users) <= 0) $ismatch = false;
                    else if (count($users) == 1 && $users[0]->userid == -1) $ismatch = true;
                    else {
                        foreach ($users as $key => $item) {
                            if ($item->userid == $userid) {
                                $ismatch = true;
                                break;
                            }
                        }
                    }
                    if ($ismatch) break;
                }
            }
            if ($ismatch) {
                array_push($res_data, $value);
            }
        }

        return response()->json(['success' => true, "data" => $res_data], 200);
    }
    public function questions(Request $request)
    {
        $userid = $request->userid;
        $data = Categories::select('*')->orderby('order')->get();

        $res_data = [];
        foreach ($data as $key => $value) {
            $value->Questions;

            $ismatch = false;
            $details = $value->UserDetails;
            if ($details == null || count($details) <= 0) $ismatch = false;
            else if (count($details) == 1 && $details[0]->userid == -1) $ismatch = true;
            else {
                foreach ($details as $detail) {
                    if ($detail->userid == $userid) {
                        $ismatch = true;
                        break;
                    }
                }
            }
            if ($ismatch) {
                array_push($res_data, $value);
            }
        }
        return response()->json(['success' => true, "data" => $res_data], 200);
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
            if ($value['match'] == true || $value['match'] == 'true') $res_value = 'match';
            else if ($value['average'] == true || $value['average'] == 'true') $res_value = 'average';
            else if ($value['none'] == true || $value['none'] == 'true') $res_value = 'none';
            else $res_value = implode(",", $value['images']);
            
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
