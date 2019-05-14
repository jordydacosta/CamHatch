<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Order as Order;

class AdminDashboardController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function index()
    {
        // fetch all the orders
        $orders = $this
            ->order
            ->get();

        // calculate the total earnings
        $total_earnings = 0;

        foreach ($orders as $order) {
            $total_earnings += $order->price;
        }

        // get the total order of the current month
        $orders_current_month = $this
            ->order
            ->whereRaw('MONTH(created_at) = ?', [date('m')])
            ->get();

        $sales_current_month = 0;

        foreach ($orders_current_month as $order_current_month) {
            $sales_current_month += $order_current_month->price;
        }

        // fetch the new orders
        $new_orders = $this
            ->order
            ->where('orderstatus_id', config("config.order_status.on_hold"))
            ->count();

        $month_array = [
            01,
            02,
            03,
            04,
            05,
            06,
            07,
            8,
            9,
            10,
            11,
            12
        ];

        $graph_data = [];
        $graph_data_camhatch = [];

        foreach ($month_array as $month) {

            $month_start = date('Y-' . $month . '-01');
            $month_end = date('Y-' . $month . '-t');

            $order_count = $this
                ->order
                ->where('orders.created_at', '>=', $month_start, 'AND')->where('orders.created_at', '<=', $month_end, 'AND')
                ->count();

            $camhatch_count = $this
                ->order
                ->where('orders.created_at', '>=', $month_start, 'AND')->where('orders.created_at', '<=', $month_end, 'AND')
                ->sum('quantity');

            array_push($graph_data, json_decode($order_count));
            array_push($graph_data_camhatch, json_decode($camhatch_count));
        }

        // total camhatch's sold
        $total_camhatch = $this->order->sum('quantity');

        return view('backend.pages.index', [
            'title'               => 'Dashboard',
            'orders'              => $orders,
            'total_earnings'      => $total_earnings,
            'sales_current_month' => $sales_current_month,
            'new_orders'          => $new_orders,
            'graph_data'          => $graph_data,
            'graph_data_camhatch' => $graph_data_camhatch,
            'total_camhatch'      => $total_camhatch
        ]);
    }
}
