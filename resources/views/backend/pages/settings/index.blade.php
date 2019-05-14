@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @yield('page-header')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
                        <li><a href="#tab2" data-toggle="tab">Shipping</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1">
                            <h4>Tab 1</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget rutrum purus. Donec
                                hendrerit ante ac metus sagittis elementum. Mauris feugiat nisl sit amet neque luctus, a
                                tincidunt odio auctor. </p>
                        </div>
                        <div class="tab-pane fade" id="tab2">
                            <h4>Tab 2</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget rutrum purus. Donec
                                hendrerit ante ac metus sagittis elementum. Mauris feugiat nisl sit amet neque luctus, a
                                tincidunt odio auctor. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop