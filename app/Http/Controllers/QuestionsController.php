<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Categories;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $category = 0;
        if ($request->has('category')) {
            $category = intval($request->category);
        }
        // category
        $categories = Categories::orderby('order')->get();
        $questions = Questions::select('*');
        if ($category > 0) {
            $questions = $questions->where('categoryid', $category);
        }
        $questions = $questions->where('deleted', 0)->orderby('question')->get();
        $users = User::where('role', '!=', 0)->orderby('name')->get();
        return view('questions.index', compact('categories', 'questions', 'users'));
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
        Categories::create($request->all());
        return redirect()->route('questions.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function edit(Questions $questions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($id > 0) {
            $users = $request->users;
            if($users == null) {
                $users = [-1];
            }
            if ($request->has('all_users') && $request->all_users == -1) {
                UserDetails::where('type', 2)->where('typeid', $id)->delete();
            } else {
                UserDetails::where('type', 2)->where('typeid', $id)->whereNotIn('userid', $users)->delete();
                foreach ($users as $key => $userid) {
                    if (UserDetails::where(['type' => 2, 'typeid' => $id, 'userid' => $userid])->count() <= 0) {
                        UserDetails::create(['type' => 2, 'typeid' => $id, 'userid' => $userid]);
                    }
                }
            }
        } else {
            Questions::updateOrCreate(['id' => $request->id], $request->all());
        }
        return redirect()->route('questions.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->type == 'category') {
            Categories::find($id)->delete();
            Questions::where('categoryid', $id)->update(['deleted' => 1]);
        } else {
            Questions::find($id)->update(['deleted' => 1]);
        }
        return redirect()->route('questions.index')->withStatus(__('Successfully deleted.'));
    }
}
