<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use Storage;
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
        $user_id = isset(Auth::user()->id)? Auth::user()->id : null;

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
              $Options_all = null;
              $Options_all = Option::where('question_id', '=', $question_id)->get();
              foreach ($Options_all as $Option) {
                $Option_text = null;
                $Option_text = isset($Option->option_text) ? $Option->option_text : null;
                $record_text = null;
                $record_text = array('question_id' => $question_id, 'option_text' => $Option_text);
                array_push($Options, $record_text);
              }
            }
            $Reply = null;
            $Reply = Reply::where('question_id', '=', $question_id)->where('user_id', '=', $user_id)->first();
            $Reply_text  = null;
            $Reply_text  = isset($Reply->reply_text) ? $Reply->reply_text : null;
            $record_text = null;
            $record_text = array('question_id' => $question_id, 'reply_text' => $Reply_text);
            array_push($Replies, $record_text);
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
        $user_id = isset(Auth::user()->id) ? Auth::user()->id : null;
        $reply_text = isset($request->reply_text)? $request->reply_text : null;
        $question_id = isset($request->question_id)? $request->question_id : null;

        $Reply = new Reply;
        $Reply->reply_text = $reply_text;
        $Reply->question_id = $question_id;
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

    public function saveImage(Request $request)
    {
        $image = Image::make($request->get('imgBase64'));
        $image->save('public/img/profile.jpg');
    }

    public function setavatareffect(Request $request)
    {
        $user = User::where('username', Auth::user()->username)->firstOrFail();
        $user_avatar_path = array_filter(File::allFiles('public/storage/users/' . Auth::user()->id . '-' . Auth::user()->reg_num),

        function ($user_avatar_path)
        {
            return preg_match('/\b' . Auth::user()->reg_num. '(.*)/', $user_avatar_path);
        });

        $path = 'public/users/' . Auth::user()->id . '-' . Auth::user()->reg_num . '/' . 'edited_avatar';
        $save_path = 'public/storage/users/' . Auth::user()->id . '-' . Auth::user()->reg_num . '/' . 'edited_avatar';
        if ( !Storage::exists ($path) ) {
            Storage::MakeDirectory($path, 0755, true);
        }
        foreach ( $user_avatar_path as $user_path )
        {
            $image = Image::make($user_path);
            $image->save($save_path . '/e_' . Auth::user()->u_avatar);
        }

        return redirect()->back();
    }
}
