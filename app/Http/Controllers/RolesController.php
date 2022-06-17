<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use App\Models\Notifications;
use App\Models\User;
use App\Models\Rating;
use App\Models\RatingDetail;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Faker $faker)
    {
        //

        // for ($i=0; $i < 4; $i++) { 
        //     User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'role' => rand(1,2),
        //         'remember_token' => Str::random(10),
        //     ]);
        // }
        // dd("success");
        $users = User::where('id', '!=', Auth::user()->id)->orderby('name')->get();
        $facilities = Facilities::select('*')->orderby('name')->get();
        return view('roles.index', compact('users', 'facilities'));
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
        $data = $request;
        if ($request->id <= 0 || ($request->has('update_password') && $request->update_password == "on")) {
            $data = $request->merge(['password' => bcrypt($request->user_password)]);
        }
        $data = $data->all();
        User::updateOrCreate(
            ['id' => $request->id],
            $request->merge($data)->all()
        );
        return redirect()->route('roles.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function show(User $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(User $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $users)
    {
        $status = 0;
        if ($request->approve === true || $request->approve === 'true') {
            $status = 1;
        } else {
            $status = 2;
        }
        User::find($request->id)->update(['status' => $status]);
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $facilities = Facilities::where('managerid', $id)->pluck('id')->toArray();
        $ratings = Rating::where('workerid', $id)->orWhereIn('facilityid', $facilities)->pluck('id')->toArray();

        Facilities::where('managerid', $id)->delete();
        Notifications::where('userid', $id)->delete();
        Rating::where('workerid', $id)->orWhereIn('facilityid', $facilities)->delete();
        RatingDetail::whereIn('ratingid', $ratings)->delete();
        User::find($id)->delete();
        return redirect()->route('roles.index')->withStatus(__('Successfully deleted.'));
    }
}
