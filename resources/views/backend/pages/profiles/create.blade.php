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
                    <div>

                    </div>
                    <div class="btn-group pull-right" style="margin-right: 1%;">
                        <a href="/admin/profiles" class="btn btn-primary">Overview</a>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div style="width: 100%;">
                        <form action="store" method="post">
                            <table class="table table-hover custom_datatable_layout" id="orders-table">
                                <thead>
                                    <tr>
                                        <th class="col-md-4 text-center">Name</th>
                                        <th class="col-md-4 text-center">Email</th>
                                        <th class="col-md-4 text-center">Password</th>
                                    </tr>
                                </thead>

                                <tr>
                                    <th class="col-md-4 text-center"><input type="text" id="name" name="name" placeholder="Enter a name here: "></th>
                                    <th class="col-md-4 text-center"><input type="text" id="email" name="email" placeholder="Enter a e-mail here: "></th>
                                    <th class="col-md-4 text-center"><input type="text" id="password" name="password" placeholder="Enter a password here: "></th>
                                    <input type="hidden" name="_token" value="{{csrf_token() }}">
                                </tr>
                            </table>
                            <input type="submit" name="submit" value="add">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal HTML -->
    {!! \Helpers::showModal("You are about to delete this order, are you sure you want to do this?", "Everything concerning this order will be lost!", 'delete_modal') !!}
    {!! \Helpers::showModal("You are about to complete this order, are you sure you want to do this?", "Make sure to double check the data before completing the order!", 'complete_modal', 'confirm') !!}
@stop
