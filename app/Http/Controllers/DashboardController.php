<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use App\Models\User;
use Illuminate\Http\Request;
use App;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admin = User::where('role', 0)->count();
        $clients = User::where('role', 1)->count();
        $worker = User::where('role', 2)->where('email', '!=', 'worker@rating.com')->count();
        $facilities = Facilities::count();
        return view('dashboard', compact('admin', 'clients', 'worker', 'facilities'));
    }
    public function changeLang($langcode)
    {
        App::setLocale($langcode);
        session()->put("lang_code", $langcode);
        return redirect()->back();
    }
}
