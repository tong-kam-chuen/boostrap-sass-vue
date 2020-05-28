<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = (\Request::get('q')) ? \Request::get('q') : null;
        $users = User::latest()->when($where,
                  function ($query) use ($where) {
                    return $query->orWhere('name', 'LIKE', "%{$where}%")
                                 ->orWhere('type', 'LIKE', "%{$where}%")
                                 ->orWhere('email','LIKE', "%{$where}%");
                  }
                )->paginate(3);

        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return $users;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'name' => 'required|string|max:255',
          'email'=> 'required|email|unique:users',
          'password' => 'required|min:6'
        ]);

        return User::create([
          'name' => $request->name,
          'email' => $request->email,
          'type' => $request->type,
          'bio' => $request->bio,
          'photo' => $request->photo,
          'password' => bcrypt($request->password)
        ]);
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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function readProfile()
    {
        return auth('api')->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $currentPhoto = $user->photo;

        $this->validate($request, [
          'name' => 'required|string|max:255',
          'email'=> 'required|email|unique:users,email,'.$user->id,
          'password' => 'sometimes|min:6',
        ]);

        if (!empty($request->password)) {
            $request->merge(['password' => bcrpt($request->password)]);
        }

        if ($request->photo != $currentPhoto) {
            $photo = time().'.'.
            explode('/',
                      explode(':',
                                substr($request->photo, 0,
                                        strpos($request->photo, ';')
                                      )
                              )[1]
                    )[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$photo);

            $request->merge(['photo' => $photo]);

            $userPhoto = public_path('img/profile/').$currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }
        $user->update($request->all());

        return ['message' => 'Profile Updated'];
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
        $this->validate($request, [
          'name' => 'required|string|max:255',
          'email'=> 'required|email|unique:users,email,'.$id,
          'password' => 'sometimes|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return ['message' => 'User Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        $user->delete();

        return ['message' => 'User Deleted'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchRecords(Request $request)
    {
        $where = (\Request::get('q')) ? \Request::get('q') : null;
        $users = User::latest()->when($where,
                  function ($query) use ($where) {
                    return $query->orWhere('name', 'LIKE', "%{$where}%")
                                 ->orWhere('type', 'LIKE', "%{$where}%")
                                 ->orWhere('email','LIKE', "%{$where}%");
                  }
                )->paginate(3);

        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return $users;
        }
    }

}
