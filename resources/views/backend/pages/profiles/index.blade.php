@extends('backend.layouts.default')

@section('content')
    @yield('page-header')
    @if(session()->has('status'))
        <div class="row">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                <strong>#</strong>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-user"></i> Users</a></li>
                            <li><a href="#"><i class="icon-shopping-cart"></i>
                                    Users</a></li>
                        </ul>
                    </div>
                    <div class="btn-group pull-right" style="margin-right: 1%;">
                        <a href="{{ route('profiles.create') }}" class="btn btn-primary glyphicon-plus"> Create new user</a>
                    </div>
                    <div class="btn-group pull-right" style="margin-right: 1%;">
                        <a href="#" class="btn btn-primary">Overview</a>
                    </div>
                    <br>
                    <br>
                    <br>
                    <!-- selector -->
{{--                    <div id="toolbar">--}}
{{--                        <ul id="navlist" class="">--}}
{{--                            <li><span id="all_orders" class="active_status_filter">All (<span--}}
{{--                                            id="all_count"></span>)</span> |--}}
{{--                            </li>--}}
{{--                            <li><span id="on_hold_orders">On hold (<span--}}
{{--                                            id="on_hold_count"></span>)</span> |--}}
{{--                            </li>--}}
{{--                            <li><span id="completed_orders">Completed (<span--}}
{{--                                            id="completed_count"></span>)</span> |--}}
{{--                            </li>--}}
{{--                            <li><span id="cancelled_orders">Cancelled (<span--}}
{{--                                            id="cancelled_count"></span>)</span></li>--}}
{{--                        </ul>--}}
{{--                        <br>--}}
{{--                    </div>--}}
                    <br>
                    <table class="table table-hover custom_datatable_layout" id="orders-table">
                        <thead>
                        <tr>
{{--                            <th class="col-md-1">--}}
{{--                                <input type="checkbox" id="check-all"/>--}}
{{--                            </th>--}}
                            <th class="col-md-2 text-center">Name</th>
                            <th class="col-md-4 text-center">Email</th>
                            <th class="col-md-4 text-center">Created at</th>
                            <th class="col-md-1 text-center">Edit</th>
                            <th class="col-md-1 text-center">Delete</th>
                        </tr>
                        </thead>
{{--                        {{ dd($profiles) }}--}}
                        @foreach($profiles as $row)

                            <tr>
                                <th class="col-md-4 text-center">{{$row['name']}}</th>
                                <th class="col-md-4 text-center">{{$row['email']}}</th>
                                <th class="col-md-4 text-center">{{$row['created_at']}}</th>
                                <th class="col-md-4 text-center"><a href="{{ route('profiles.edit', $row['id']) }}"><i class="icon-edit"></i></a></th>
                                <th class="col-md-4 text-center"><a href="{{ route('profiles.delete', $row['id']) }}"><i class="icon-trash"></i></a></th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal HTML -->
    {!! \Helpers::showModal("You are about to delete this order, are you sure you want to do this?", "Everything concerning this order will be lost!", 'delete_modal') !!}
    {!! \Helpers::showModal("You are about to complete this order, are you sure you want to do this?", "Make sure to double check the data before completing the order!", 'complete_modal', 'confirm') !!}
@stop
