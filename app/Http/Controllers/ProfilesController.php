<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Profiles;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profiles::all()->toArray();
        return view('backend.pages.profiles.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.profiles.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $profiles = new Profiles;
        $profiles->name = Input::get("name");
        $profiles->email = Input::get("email");
        $profiles->password = Input::get("password");
        $profiles->save();
        $profiles = Profiles::all()->toArray();
        return view('backend.pages.profiles.index', compact('profiles'));
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
        $profiles = Profiles::find($id);
        return view('backend.pages.profiles.update', compact('profiles'));
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
              $request->validate([
                'name'=>'required',
                'email'=> 'required',
                'password' => 'required'
              ]);
              $profiles = Profiles::find($id);
                           $profiles->name = Input::get("name");
                           $profiles->email = Input::get("email");
                           $profiles->password = Input::get("password");
                           $profiles->save();
                           $profiles = Profiles::all()->toArray();
              return view('backend.pages.profiles.index', compact('profiles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profiles::find($id);
        $profile->delete();

        $profiles = Profiles::all()->toArray();
        return view('backend.pages.profiles.index', compact('profiles'));
    }
}
