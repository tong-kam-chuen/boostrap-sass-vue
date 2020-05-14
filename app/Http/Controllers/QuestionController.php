<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Questions = Question::all();

        return view('Question.index')->with(['Questions' => $Questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Question = new Question;
        $Question->question_text = $request->question_text;
        $Question->question_date = $request->question_date;
        $Question->question_type = $request->question_type;
        $Question->question_select = $request->question_select;
        $Question->questionaire_id = $request->questionaire_id;
        $Question->save();

        return response()->json($Question);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Question = Question::findOrFail($id);

        return view('Question.show')->with(['Question' => $Question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $Question = Question::findOrFail($id);

        return view('Question.edit')->with(['Question' => $Question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->session()->flash('success', 'Record updated successfully.');
        return redirect()->back();
        $Question = Question::findOrFail($id);
        $Question->update($request->all());

        return response()->json($Question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Question = Question::findOrFail($id);
        $Question->delete();

        return response()->json($Question);
    }
}
