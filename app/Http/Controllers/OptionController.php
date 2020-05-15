<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Option;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Options = Option::where('question_id', request()->question_id)->get();

        return view('Option.index')->with(['Options' => $Options , 'question_id' => request()->question_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Option.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Option = new Option;
        $Option->option_text = $request->option_text;
        $Option->option_date = $request->option_date;
        $Option->question_id = $request->question_id;
        $Option->save();

        return response()->json($Option);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Option = Option::findOrFail($id);

        return view('Option.show')->with(['Option' => $Option]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $Option = Option::findOrFail($id);

        return view('Option.edit')->with(['Option' => $Option]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Option = Option::findOrFail($id);
        $Option->update($request->all());

        return response()->json($Option);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Option = Option::findOrFail($id);
        $Option->delete();

        return response()->json($Option);
    }
}
