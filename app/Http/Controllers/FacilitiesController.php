<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use App\Models\Rating;
use App\Models\User;
use App\Models\RatingDetail;
use Illuminate\Http\Request;
use Auth;


class FacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 1)->orderby('name')->get();
        $facilities = Facilities::select("*");
        if(Auth::user()->role == 1) {
            $facilities = $facilities->where('managerid', Auth::user()->id);
        }
        $facilities = $facilities->orderby('name')->get();
        return view('facilities.index', compact('facilities', 'users'));
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
        Facilities::updateOrCreate(
            [
                'id' => $request->id
            ],
            $request->all()
        );
        return redirect()->route('facilities.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facilities  $Facilitiess
     * @return \Illuminate\Http\Response
     */
    public function show(Facilities $Facilitiess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facilities  $Facilitiess
     * @return \Illuminate\Http\Response
     */
    public function edit(Facilities $Facilitiess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facilities  $Facilitiess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facilities $Facilitiess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facilities  $Facilitiess
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $ratings = Rating::where('workerid', $id)->orWhere('facilityid', $id)->pluck('id')->toArray();

        Rating::where('workerid', $id)->orWhere('facilityid', $id)->delete();
        RatingDetail::whereIn('ratingid', $ratings)->delete();

        Facilities::find($id)->delete();
        return redirect()->route('facilities.index')->withStatus(__('Successfully deleted.'));
    }
}
