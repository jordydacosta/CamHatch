<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User as User;

use App\Http\Requests\EditProfileRequest;

use Response, DB, Input;

class UserController extends Controller
{
    protected $User;

    public function __construct(User $User)
    {
        $this->User = $User;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.pages.users.index', ['title' => 'Users']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(EditProfileRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->User->find($id)->delete()) {
            return Response::json(array(
                    'deleted' => 1
                )
            );
        }

        return Response::json(array(
                'deleted' => 0
            )
        );
    }

    public function getData()
    {
        // get a random review to display on the home page
        $users = $this->User->select('id as i', 'name', 'email', 'password', 'remember_token', 'created_at', 'updated_at')->orderBy('created_at', 'ASC');

        return datatables()->of($users)
//            ->editColumn('description', '<div class="description_container"><div class="inline_description" data-id="{{ $i }}">{{ $description }}</div></div>')
//            ->editColumn('description_en', '<div class="description_en_container"><div class="inline_description_en" data-id="{{ $i }}">{{ $description_en }}</div></div>')
//            ->addColumn('actions', '<button class="state_review btn btn-xs btn-default" data-id="{{$i}}" data-state="{{$v}}"><i class="@if($v == 1) icon-checkbox-checked @else icon-checkbox-unchecked @endif"></i></button> <button class="remove_review btn btn-xs btn-danger" data-id="{{$i}}"><i class="icon-trash"></i></button>')
//            ->removeColumn('i')
//            ->rawColumns(['description', 'description_en', 'actions'])
            ->make();

    }
}
