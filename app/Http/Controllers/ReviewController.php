<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Review as Review;

use yajra\Datatables\Datatables;

use Response, DB, Input;

class ReviewController extends Controller
{

    protected $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.pages.reviews.index', ['title' => 'Reviews']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->review->find($id)->delete()) {
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

    /**
     * Change the active state to blocked or active
     */
    public function changeState($id)
    {
        DB::beginTransaction();

        // fetch the deed
        $review = $this->review->find($id);

        $review->visible = Input::get('state');

        if ($review->save()) {
            DB::commit();

            return Response::json(array(
                    'changed' => 1
                )
            );
        }
    }

    public function getData()
    {
        // get a random review to display on the home page
        $reviews = $this->review->select('id as i', 'name', 'rating', 'description', 'description_en', 'created_at', 'visible as v')->orderBy('created_at', 'ASC');

        return datatables()->of($reviews)
            ->editColumn('description', '<div class="description_container"><div class="inline_description" data-id="{{ $i }}">{{ $description }}</div></div>')
            ->editColumn('description_en', '<div class="description_en_container"><div class="inline_description_en" data-id="{{ $i }}">{{ $description_en }}</div></div>')
            ->addColumn('actions', '<div class="btn-group" role="group"><button class="state_review btn btn-xs btn-info" data-id="{{$i}}" data-state="{{$v}}"><i class="@if($v == 1) icon-checkbox-checked @else icon-checkbox-unchecked @endif"></i></button> <button class="remove_review btn btn-xs btn-danger" data-id="{{$i}}"><i class="icon-trash"></i></button></div>')
            ->removeColumn('v')
            ->removeColumn('i')
            ->rawColumns(['description', 'description_en', 'actions'])
            ->make();

    }
}
