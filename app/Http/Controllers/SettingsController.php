<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('settings.index');
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
        $phone = $request->phonenumber;
        $phone = str_replace(" ", "", $phone);
        if($phone != "") {
            $phone = "+966".$phone;
        }
        $data = $request->only('name', 'email');
        $data['phonenumber'] = $phone;
        Auth::user()->update($data);
        if($request->has('update_password') && $request->update_password === 'on') {
            $password = $request->password;
            $c_password = $request->c_password;
            if($password == null || $password == "") {
                return redirect()->route('settings.index')->withErrors(__('Password is empty.'));
            } if($password != $c_password) {
                return redirect()->route('settings.index')->withErrors(__('Confirm password not match.'));
            }
            Auth::user()->update(['password' => bcrypt($password)]);
        }
        return redirect()->route('settings.index')->withStatus(__('Successfully updated.'));
        // update_password
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
