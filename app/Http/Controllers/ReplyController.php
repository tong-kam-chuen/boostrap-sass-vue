<?php

namespace App\Http\Controllers;

use Auth;
use App\Reply;
use App\Option;
use App\Question;
use App\Questionnaire;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Questionnaire = null;
        $Questions = null;
        $Options = array();
        $Replies = array();
        $Questionnaire = Questionnaire::where('is_published', '=', '1')->where('id', '=', request()->questionnaire_id)->first();
        if (!is_null($Questionnaire)) {
          $Questions = Question::where('questionnaire_id', '=', request()->questionnaire_id)->get();
          foreach ($Questions as $Question) {
            $question_id = isset($Question->id) ? $Question->id : null;
            $question_type = isset($Question->question_type) ? $Question->question_type : null;
            if ($question_type == 'option') {
              $Option = null;
              $Option = Option::where('question_id', '=', $question_id)->get();
              $Option_text = null;
              $Option_text = isset($Option->option_text) ? $Option->option_text : null;
              array_push($Options[$question_id], $Option_text);
            }
            $Reply = null;
            $Reply = Reply::where('question_id', '=', $question_id)->get();
            $Reply_text = null;
            $Reply_text = isset($Reply->reply_text) ? $Reply->reply_text : null;
            array_push($Replies[$question_id], $Reply_text);
          }
        }

        return view('Reply.index')->with(['Questionnaire' => $Questionnaire , 'Questions' => $Questions , 'Options' => $Options , 'Replies' => $Replies , 'questionnaire_id' => request()->questionnaire_id]);
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
        $user_id = isset(Auth::user()->id)? Auth::user()->id : null;

        $Reply = new Reply;
        $Reply->reply_text = $request->reply_text;
        $Reply->question_id = $request->question_id;
        $Reply->user_id = $user_id;
        $Reply->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //
    }
}
