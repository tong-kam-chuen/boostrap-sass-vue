<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Questionnaire;

class QuestionnaireController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $Questionnaires = Questionnaire::orderBy('id', 'DESC')->get();

        return view('Questionnaire.index')->with(['Questionnaires' => $Questionnaires]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Questionnaire = new Questionnaire;
        $Questionnaire->questionnaire_name = $request->questionnaire_name;
        $Questionnaire->questionnaire_date_start = $request->questionnaire_date_start;
        $Questionnaire->questionnaire_date_end = $request->questionnaire_date_end;
        $Questionnaire->save();

        return response()->json($Questionnaire);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $Questionnaire = Questionnaire::find($id);

        return view('Questionnaire.show')->with(['Questionnaire' => $Questionnaire]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $Questionnaire = Questionnaire::find($id);

        return view('Questionnaire.edit')->with(['Questionnaire' => $Questionnaire]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Questionnaire = Questionnaire::findOrFail($id);
        $Questionnaire->questionnaire_name = $request->questionnaire_name;
        $Questionnaire->questionnaire_date_start = $request->questionnaire_date_start;
        $Questionnaire->questionnaire_date_end = $request->questionnaire_date_end;
        $Questionnaire->save();

        return response()->json($Questionnaire);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Questionnaire  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Questionnaire = Questionnaire::findOrFail($id);
        $Questionnaire->delete();

        return response()->json($Questionnaire);
    }

    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus()
    {
        $Questionnaire = Questionnaire::findOrFail(request()->id);
        $Questionnaire->is_published = !$Questionnaire->is_published;
        $Questionnaire->save();

        return response()->json($Questionnaire);
    }
}
