<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facilities;
use App\Models\Categories;
use App\Models\User;
use DB;
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
        $start_date = [];
        $end_date = [];
        if ($request->has('facilities')) $facilityids = explode(",", $request->facilities);
        if ($request->has('categories')) $categoryids = explode(",", $request->categories);
        if ($request->has('workers')) $workerids = explode(",", $request->workers);
        if ($request->has('start_date')) $start_date = $request->start_date;
        if ($request->has('end_date')) $start_date = $request->end_date;

        $categories = Categories::orderby('title')->get();
        $workers = User::where('role', 2)->where('email', '!=', 'worker@rating.com')->orderby('name')->get();
        $facilities = [];
        $data = Facilities::orderby('name')->get();
        foreach ($data as $key => $value) {
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
                            if (in_array($item->userid, $workerids)) {
                                $ismatch = true;
                                break;
                            }
                        }
                    }
                    if ($ismatch) break;
                }
            }
            if ($ismatch) array_push($facilities, $value);
        }
        $facility_users = DB::select(DB::raw("SELECT t1.id, t1.name, t3.userid FROM facilities AS t1 LEFT JOIN office AS t2 ON t1.id = t2.facilityid LEFT JOIN user_details AS t3 ON t2.id = t3.typeid WHERE t3.type = 0"));
        $reports = Facilities::from('users as t0')
            ->selectRaw("t1.id as facilityid, t5.id as categoryid, t2.workerid as workerid,
            SUM(CASE WHEN t3.res_key = 'none' THEN 0 ELSE 1 END) AS total_score, 
            SUM(CASE WHEN t3.res_key = 'nonmatch' THEN 0 ELSE 1 END) AS cur_score")
            ->leftjoin('ratings as t2', 't0.id', 't2.workerid')
            ->leftjoin('facilities as t1', 't1.id', 't2.facilityid')
            ->leftjoin('rating_details as t3', 't2.id', 't3.ratingid')
            ->leftjoin('questions as t4', 't3.type', 't4.id')
            ->leftjoin('categories as t5', 't4.categoryid', 't5.id')
            ->whereIn('t2.workerid', $workerids)
            ->whereIn('t1.id', $facilityids)
            ->whereIn('t5.id', $categoryids);

        if ($request->has('start_date')) {
            $start_date = date('Y-m-d H:i:s', strtotime($request->start_date . " 00:00:00"));
            $reports = $reports->where('t2.created_at', ">=", $start_date);
        }
        if ($request->has('end_date')) {
            $end_date = date('Y-m-d H:i:s', strtotime($request->end_date . " 23:59:59"));
            $reports = $reports->where('t2.created_at', "<=", $end_date);
        }

        $reports = $reports->groupby('t2.workerid', 't1.id', 't5.id')
            ->orderby('t2.workerid')
            ->orderby('t1.id')
            ->orderby('t5.id')
            ->get()->toArray();
        return view('worker-reports.index', compact('facilities', 'categories', 'reports', 'workers', 'facility_users'));
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
