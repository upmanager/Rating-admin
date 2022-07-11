<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facilities;
use App\Models\User;
use PDF;

class WorkerReportsController1 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $facilityids = [];
        $workerids = [];
        if ($request->has('facilities')) $facilityids = explode(",", $request->facilities);
        if ($request->has('workers')) $workerids = explode(",", $request->workers);

        $facilities = Facilities::orderby('name')->get();
        $workers = User::orderby('name')->where('role', 2)->where('email', '!=', 'worker@rating.com')->get();

        $reports = Facilities::from('facilities as t1')->selectRaw("t1.id as facilityid, t3.id as workerid, count(*) as visit")
            ->leftjoin('ratings as t2', 't1.id', 't2.facilityid')
            ->leftjoin('users as t3', 't3.id', 't2.workerid')
            ->whereIn('t1.id', $facilityids)
            ->whereIn('t3.id', $workerids)
            ->groupby('t1.id', 't3.id')->get()->toArray();
        return view('worker-reports.index', compact('facilities', 'workers', 'reports'));
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
        $data = $request->table_data;
        $name =  date("Ymd");
        // return view('exports.report', compact('data'));
        $pdf = PDF::loadView('exports.report', compact('data'));
        // $stram = $pdf->stream();
        return $pdf->download("reports_$name.pdf");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
