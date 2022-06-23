<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Facilities;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Http\Request;
use Auth;
use PDF;
use Excel;
use App\Exports\excelExport;

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
        if($facility == 0) {
            $facility = Facilities::select('id')->orderby('name')->first();
            return redirect()->route('ratings.index', 'facility='.$facility->id);
        }
        $users = User::where('role', 1)->orderby('name')->get();
        $facilities = Facilities::select("*");
        if (Auth::user()->role == 1) {
            $facilities = $facilities->where('managerid', Auth::user()->id);
        }
        $facilityids = $facilities->pluck('id')->toArray();
        $facilities = $facilities->orderby('name')->get();
        $ratings = Rating::select("*")->whereIn('facilityid', $facilityids);
        if ($facility > 0) {
            $ratings = $ratings->where('facilityid', $facility);
        }
        if (Auth::user()->role != 0) {
            $ratings = $ratings->where('status', 1);
        }
        $ratings = $ratings->orderby('id')->get();
        foreach ($ratings as $key => $rating) {
            $rating->Worker;
            if ($rating->Facility) $rating->Facility->Manager;
            if ($rating->Details) foreach ($rating->Details as $dt) $dt->Question;
        }
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
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '3600');

        $id = $request->id;
        $type = $request->type;

        $rating = Rating::find($id);
        $facilityid = $rating->facilityid;
        $facility = Facilities::find($facilityid);
        $q_cats = Categories::orderby('order')->orderby('id')->get();
        $cats_data = [];
        $index = 0;
        $total = 0;
        $res_total = 0;
        foreach ($q_cats as $cat_key => $cat) {
            $tmp_arr = [];

            foreach ($cat->Questions as $q_key => $quest) {
                foreach ($quest->RatingDetails as $d_key => $detail) {
                    if ($detail->ratingid == $id) {
                        $score = 0;
                        if ($detail->res_value === 'true' || $detail->res_value === true) {
                            $score = $quest->score;
                        }
                        $index += 1;
                        $res_total += $score;
                        $total += $quest->score;
                        $tmp_data = ['index' => $index, 'cat' => false, 'title' => $quest->question, 'max' => $quest->score, 'score' => $score];
                        array_push($tmp_arr, $tmp_data);
                        break;
                    }
                }
            }
            if (count($tmp_arr) > 0) {
                $tmp_data = ['cat' => true, 'title' => $cat->title];
                array_push($cats_data, $tmp_data);
                $cats_data = array_merge($cats_data, $tmp_arr);
            }
        }
        $name =  date("Ymd");
        $created_date = $rating->created_at;

        $data = compact('facility', 'cats_data', 'total', 'res_total', 'created_date');

        if ($type == 0) {
            // return view('exports.pdf', $data);
            $pdf = PDF::loadView('exports.pdf', $data);
            // return $pdf->stream();
            return $pdf->download("reports_$name.pdf");
        } else {
            // return view('exports.excel', $data);
            return Excel::download(new excelExport($data), "reports_$name.xlsx");
        }
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
