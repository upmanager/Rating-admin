<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Facilities;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Http\Request;
use Auth;
use PDF;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $facility = 0;
        if ($request->has('facility')) {
            $facility = intval($request->facility);
        }
        $users = User::where('role', 1)->orderby('name')->get();
        $facilities = Facilities::select("*");
        if (Auth::user()->role == 1) {
            $facilities = $facilities->where('managerid', Auth::user()->id);
        }
        $facilities = $facilities->orderby('name')->get();
        $ratings = Rating::select("*");
        if ($facility > 0) {
            $ratings = $ratings->where('facilityid', $facility);
        }
        if (Auth::user()->role != 0) {
            $ratings = $ratings->where('status', 1);
        }
        $ratings = $ratings->orderby('id')->get();
        return view('rating.index', compact('facilities', 'ratings', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $facilityid = $request->facilityid;
        $facility = Facilities::find($facilityid);
        $q_cats = Categories::orderby('order')->orderby('id')->get();
        $cats_data = [];
        $index = 0;
// 177
// 251
        foreach ($q_cats as $cat_key => $cat) {
            $tmp_arr = [];

            foreach ($cat->Questions as $q_key => $quest) {
                foreach ($quest->RatingDetails as $d_key => $detail) {
                    if($detail->Rating && $detail->Rating->facilityid == $facilityid) {
                        $score = 0;
                        if ($detail->res_value === null || $detail->res_value === '' || $detail->res_value === 'true' || $detail->res_value === true) {
                            $score = $quest->score;
                        }
                        $index += 1;
                        $tmp_data = ['index' => $index, 'cat' => false, 'title' => $quest->question, 'max' => $quest->score, 'score' => $score];
                        array_push($tmp_arr, $tmp_data);
                        break;
                    }
                }
            }
            if(count($tmp_arr) > 0) {
                $tmp_data = ['cat' => true, 'title' => $cat->title];
                array_push($cats_data, $tmp_data);
                $cats_data = array_merge($cats_data, $tmp_arr);
            }
        }

        $name =  date("Ymd");
        $pdf = PDF::loadView('pdf', compact('facility', 'cats_data'));
        // return view('pdf', compact('facility', 'cats_data'));
        // return $pdf->stream();
        return $pdf->download("reports_$name.pdf");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = 0;
        if ($request->approve === true || $request->approve === 'true') {
            $status = 1;
        } else {
            $status = 2;
        }
        Rating::find($request->id)->update(['status' => $status]);
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('ratings.index')->withStatus(__('Successfully deleted.'));
    }
}
