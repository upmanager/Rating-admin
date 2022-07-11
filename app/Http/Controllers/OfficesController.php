<?php

namespace App\Http\Controllers;

use App\Models\Offices;
use App\Models\Facilities;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;

class OfficesController extends Controller
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
        $facilities = Facilities::orderby('name')->get();
        $offices = Offices::select('*');
        if ($facility > 0) {
            $offices = $offices->where('facilityid', $facility);
        }
        $offices = $offices->orderby('name')->get();
        $users = User::where('role', 2)->where('email', '!=', 'worker@rating.com')->orderby('name')->get();

        return view('offices.index', compact('facilities', 'offices', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        Offices::updateOrCreate(['id' => $request->id], $request->all());
        return redirect()->route('offices.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offices $offices
     * @return \Illuminate\Http\Response
     */
    public function show(Offices $offices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offices $offices
     * @return \Illuminate\Http\Response
     */
    public function edit(Offices $offices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offices $offices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $users = $request->users;
        if ($users == null) {
            $users = [];
        } else if ($request->has('all_users') && $request->all_users == -1) {
            $users = [-1];
        }

        UserDetails::where('type', 0)->where('typeid', $id)->whereNotIn('userid', $users)->delete();
        foreach ($users as $key => $userid) {
            if (UserDetails::where(['type' => 0, 'typeid' => $id, 'userid' => $userid])->count() <= 0) {
                UserDetails::create(['type' => 0, 'typeid' => $id, 'userid' => $userid]);
            }
        }
        return redirect()->route('offices.index')->withStatus(__('Successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offices $offices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Offices::find($id)->delete();
        return redirect()->route('offices.index')->withStatus(__('Successfully deleted.'));
    }
}
