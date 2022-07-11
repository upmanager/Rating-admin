<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facilities;
use App\Models\Categories;
use App\Models\User;
use PDF;

class WorkerReportsController extends Controller
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
        $categoryids = [];
        $workerids = [];
        if ($request->has('facilities')) $facilityids = explode(",", $request->facilities);
        if ($request->has('categories')) $categoryids = explode(",", $request->categories);
        if ($request->has('workers')) $workerids = explode(",", $request->workers);

        $facilities = Facilities::orderby('name')->get();
        $categories = Categories::orderby('title')->get();
        $workers = User::where('role', 2)->orderby('name')->get();

        $reports = Facilities::from('users as t0')
            ->selectRaw("t1.id as facilityid, t5.id as categoryid, t2.workerid as workerid,
            SUM(CASE WHEN t3.res_key = 'none' THEN 0 ELSE t4.score END) AS total_score, 
            SUM(CASE WHEN t3.res_key = 'match' THEN t4.score WHEN t3.res_key = 'average' THEN (t4.score DIV 2) ELSE 0 END) AS cur_score")
            ->leftjoin('ratings as t2', 't0.id', 't2.workerid')
            ->leftjoin('facilities as t1', 't1.id', 't2.facilityid')
            ->leftjoin('rating_details as t3', 't2.id', 't3.ratingid')
            ->leftjoin('questions as t4', 't3.type', 't4.id')
            ->leftjoin('categories as t5', 't4.categoryid', 't5.id')
            ->whereIn('t2.workerid', $workerids)
            ->whereIn('t1.id', $facilityids)
            ->whereIn('t5.id', $categoryids)
            ->groupby('t2.workerid', 't1.id', 't5.id')
            ->orderby('t2.workerid')
            ->orderby('t1.id')
            ->orderby('t5.id')
            ->get()->toArray();
        return view('worker-reports.index', compact('facilities', 'categories', 'reports', 'workers'));
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
