<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rates = [];
        $ratings = Rating::where('status', 1)->get();
        foreach ($ratings as $rkey => $rating) {
            $facility = "";
            if ($rating->Facility) $facility = $rating->Facility->name;
            if ($facility == null || $facility == "") $facility = $rating->facilityid;

            $rate = 0;
            $total_rate = 0;
            $details = $rating->Details;
            if ($details) {
                foreach ($details as $detail) {
                    if ($detail->res_key != 'ratings') continue;
                    if ($detail->Question == null) continue;
                    $total_rate += $detail->Question->score;
                    if ($detail->res_value !== 'true' && $detail->res_value !== true) continue;
                    $rate += $detail->Question->score;
                }
            }
            $time = strtotime($rating->created_at);
            $date = date('d/M', $time);
            array_push($rates, ['facilityid' => $rating->facilityid, 'name' => $facility, 'rate' => $rate, 'total_rate' => $total_rate, 'date' => $date, 'timestamps' => $time, 'ratio' => 1]);
        }

        $rate_by_facility = [];
        $rate_by_date = [];
        foreach ($rates as $key => $rateItem) {
            $facilityid = $rateItem['facilityid'];

            $fIndex = collect($rate_by_facility)->search(function ($value, $key) use ($facilityid) {
                return $value['facilityid'] == $facilityid;
            });
            if ($fIndex === false) {
                array_push($rate_by_facility, $rateItem);
            } else {
                $rate_by_facility[$fIndex]['rate'] += $rateItem['rate'];
                $rate_by_facility[$fIndex]['total_rate'] += $rateItem['total_rate'];
            }


            $dateValue = $rateItem['date'];
            $dIndex = collect($rate_by_date)->search(function ($value, $key) use ($dateValue) {
                return $value['date'] == $dateValue;
            });
            if ($dIndex === false) {
                array_push($rate_by_date, $rateItem);
            } else {
                $rate_by_date[$dIndex]['rate'] += $rateItem['rate'];
                $rate_by_date[$dIndex]['total_rate'] += $rateItem['total_rate'];
            }
        }

        $rate_by_facility = collect($rate_by_facility)->sortByDesc('rate')->toArray();
        $rate_by_date = collect($rate_by_date)->sortByDesc('timestamps')->toArray();
        return view('analysis.index', compact('rates', 'rate_by_facility', 'rate_by_date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
