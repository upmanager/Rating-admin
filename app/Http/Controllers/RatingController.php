<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Facilities;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

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
        if(Auth::user()->role == 1) {
            $facilities = $facilities->where('managerid', Auth::user()->id);
        }
        $facilities = $facilities->orderby('name')->get();
        $ratings = Rating::select("*");
        if ($facility > 0) {
            $ratings = $ratings->where('facilityid', $facility);
        }
        if(Auth::user()->role != 0) {
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
    public function update(Request $request, $id)
    {
        $status = 0;
        if($request->approve === true || $request->approve === 'true') {
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
