@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @yield('page-header')

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-3">
            <div class="panel panel-blue panel-widget ">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <span class="icon-shopping-cart large-icon"></span style="font-size: 3em
                        ;">
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">{{ $new_orders }}</div>
                        <div class="text-muted">New Orders</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12 col-lg-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <span class="icon-moneybag large-icon"></span>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">&euro; {{ $total_earnings }}</div>
                        <div class="text-muted">Total earnings</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12 col-lg-3">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <em class="icon-dollar large-icon"></em>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">&euro; {{ $sales_current_month }}</div>
                        <div class="text-muted">Sales this month</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12 col-lg-3">
            <div class="panel panel-red panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <em class="icon-video-camera large-icon"></em>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">{{ $total_camhatch }}</div>
                        <div class="text-muted">Total CamHatch's sold</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Order Overview</div>
                <div class="panel-body">
                    <div class="canvas-wrapper">
                        <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.row-->
@stop


@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {

            var data_1 = {{ json_encode($graph_data) }};
            var data_2 = {{ json_encode($graph_data_camhatch) }};

            var lineChartData = {
                labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"],
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: data_1
                    },
                    {
                        label: "My Second dataset",
                        fillColor: "rgba(48, 164, 255, 0.2)",
                        strokeColor: "rgba(48, 164, 255, 1)",
                        pointColor: "rgba(48, 164, 255, 1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(48, 164, 255, 1)",
                        data: data_2
                    }

                ]
            }

            var chart1 = document.getElementById("line-chart").getContext("2d");
            window.myLine = new Chart(chart1).Bar(lineChartData, {
                responsive: true,
            });
        });
    </script>
@stop
