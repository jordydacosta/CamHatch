@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @yield('page-header')
    @if(session()->has('status'))
        <div class="row">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    <strong>{{session()->get('status')}}</strong>
                </div>
            </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="btn-group pull-right" role="group">
                        <a href="{{route('overview')}}"       class="btn btn-primary"><i class="icon-eye"></i> Overview</a>
                        <a href="{{ route('order.editor') }}" class="btn btn-primary glyphicon-plus"> Create new orders</a>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-export"></i> Export as CSV <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('orders_export', 'users') }}"><i class="icon-user"></i> Users</a></li>
                            <li><a href="{{ route('orders_export', 'orders') }}"><i class="icon-shopping-cart"></i>Orders</a></li>
                        </ul>
                    </div>
                    <br>
                    <br>
                    <br>
                    <!-- selector -->
                    <div id="toolbar">
                        <ul id="navlist" class="">
                            <li><span id="all_orders" class="active_status_filter">All (<span
                                            id="all_count">{{ $orders[0]->all_orders }}</span>)</span> |
                            </li>
                            <li><span id="on_hold_orders">On hold (<span
                                            id="on_hold_count">{{ $orders[0]->on_hold }}</span>)</span> |
                            </li>
                            <li><span id="completed_orders">Completed (<span
                                            id="completed_count">{{ $orders[0]->completed }}</span>)</span> |
                            </li>
                            <li><span id="cancelled_orders">Cancelled (<span
                                            id="cancelled_count">{{ $orders[0]->cancelled }}</span>)</span></li>
                        </ul>
                        <br>
                        <!--Toolbar apply -->
                        <div class="row">
                            <div class="col-md-2">
                                <select name="order-status" id="order-status" class="form-control">
                                    @foreach(config('config.order_status') as $value)
                                        <option value="{{ $value }}">@lang('backend.order_status.'.$value)</option>
                                    @endforeach
                                    <option value="0">Delete</option>
                                </select>
                            </div>
                            <div class="col-md-10 row">
                                <button class="btn btn-primary ladda-button" data-style="expand-right" id="apply_status"
                                        type="button" disabled="true">Apply
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <table class="table table-hover custom_datatable_layout" id="orders-table">
                        <thead>
                        <tr>
                            <th class="col-md-1">
                                <input type="checkbox" id="check-all"/>
                            </th>
                            <th class="col-md-2">Order</th>
                            <th class="col-md-1">Status</th>
                            <th class="col-md-2 text-center">Purchased</th>
                            <th class="col-md-2">Ship to</th>
                            <th class="col-md-1 text-center">Date</th>
                            <th class="col-md-2">Total</th>
                            <th class="col-md-2 text-right">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal HTML -->
    {!! \Helpers::showModal("You are about to delete this order, are you sure you want to do this?", "Everything concerning this order will be lost!", 'delete_modal') !!}
    {!! \Helpers::showModal("You are about to complete this order, are you sure you want to do this?", "Make sure to double check the data before completing the order!", 'complete_modal', 'confirm') !!}
@stop

@section('javascript')
    <script type="text/javascript">
        var order_id;

        $(document).ready(function() {

            var data = '{{ route('orders_data') }}';
            var l_btn_apply = Ladda.create(document.querySelector('#apply_status'));
            var l_btn_confirm = Ladda.create(document.querySelector('#submit_modal_confirm'));

            var oTable = $('#orders-table').DataTable({
                "dom": '<"toolbar">frtip',
                processing: true,
                serverSide: true,
                bLengthChange: false,
                bFilter: true,
                ajax: data,
                "fnDrawCallback": function(oSettings) {
                    $('.remove_order').on('click', function() {
                        order_id = $(this).data('id');
                        $("#delete_modal").modal('show');
                    });

                    $('.complete_order').on('click', function() {
                        order_id = $(this).data('id');
                        $("#complete_modal").modal('show');
                    });

                    $('.check-row').click(function() {
                        if ($('[name="check-row"]:checked').length > 0) {
                            $('#apply_status').prop('disabled', false);
                        } else {
                            $('#apply_status').prop('disabled', true);
                        }
                    });
                },
                "aaSorting": [[5, "desc"]],
                "aoColumns": [
                    {"data": "id", "bSortable": false, "bSearchable": false},
                    {"data": "orderstatus_id"},
                    {"data": "orderId"},
                    {"data": "quantity", sClass: "text-center"},
                    {"data": "firstname"},
                    {"data": "created_at", sClass: "text-right"},
                    {"data": "price", sClass: "text-right",},
                    {"data": "actions", "bSortable": false, sClass: "text-right", "bSearchable": false} // disable sorting for last column
                ]
            });

            /**
             * Check all the orders
             */
            $('#check-all').click(function() {
                $(':checkbox', oTable.rows().nodes()).prop('checked', this.checked);

                if (this.checked) {
                    $('#apply_status').prop('disabled', false);
                } else {
                    $('#apply_status').prop('disabled', true);
                }
            });

            /**
             * Apply the selected status to the selected orders
             */
            $('#apply_status').click(function() {

                // start the loading button
                l_btn_apply.start();

                var selected_status = $('#order-status option:selected').val();
                var selected_rows = [];
                var route = "{{{ route('order_update_status') }}}"
                var method = "POST";

                $('input[name=check-row]:checked').each(function() {
                    selected_rows.push($(this).val());
                });

                var data = {
                    new_status: selected_status,
                    rows: selected_rows
                };

                // check if the user wants to delete row(s)
                if (selected_status == 0) {
                    deleteResource("{{{ route('orders') }}}", data, oTable);

                    // stop loading
                    l_btn_apply.stop();

                    oTable.ajax.reload(null, false);

                    $('#check-all').prop('checked', false);
                    $('#apply_status').prop('disabled', true);

                    // update the order count
                    updateOrderCount();
                } else {
                    handleAjaxRequests(route, data, method).done(function(data) {
                        if (data.changed == 1) {
                            // stop loading
                            l_btn_apply.stop();

                            oTable.ajax.reload(null, false);

                            $('#check-all').prop('checked', false);
                            $('#apply_status').prop('disabled', true);

                            // update the order count
                            updateOrderCount();
                        }
                    });
                }
            });

            /**
             * Delete the selected order
             */
            $("#submit_modal_delete").click(function() {
                let alertFnc = function () { alert('done') };
                deleteResource("{{{ route('orders') }}}", {rows: [order_id]}, oTable, alertFnc);

                // update the order count
                updateOrderCount();
            });

            $("#submit_modal_confirm").click(function() {
                l_btn_confirm.start();

                handleAjaxRequests("{{{ route('orders') }}}/" + order_id, {}, 'PUT').done(function(data) {
                    if (data.changed == 1) {
                        $(".modal").modal('hide');

                        l_btn_confirm.stop();

                        oTable.ajax.reload(null, false);

                        // update the order count
                        updateOrderCount();
                    }
                });
            });

            /**
             * Filters
             */
            $('#all_orders').click(function() {
                removeActiveElement($(this));
                oTable.ajax.url('{{ route("orders_data") }}').load();
            });

            $('#on_hold_orders').click(function() {
                removeActiveElement($(this));
                oTable.ajax.url('{{ route("orders_data", config("config.order_status.on_hold")) }}').load();
            });

            $('#completed_orders').click(function() {
                removeActiveElement($(this));
                oTable.ajax.url('{{ route("orders_data", config("config.order_status.completed")) }}').load();
            });

            $('#cancelled_orders').click(function() {
                removeActiveElement($(this));
                oTable.ajax.url('{{ route("orders_data", config("config.order_status.cancelled")) }}').load();
            });
        });

        /**
         * Remove the active element on the current selected filter and move it to the newly selected filter
         * @param  {[type]} element [description]
         * @return {[type]}         [description]
         */
        function removeActiveElement(element) {
            $('#navlist > li > span').removeClass('active_status_filter');
            element.addClass('active_status_filter');
        }

        /**
         * Update the order count toolbar
         * @return {[type]} [description]
         */
        function updateOrderCount() {
            handleAjaxRequests("{{{ route('order_status_count') }}}", {}, 'GET').done(function(data) {
                // loop through JSON object and assign the correct value to the designated order status
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        $('#' + key + '_count').text(data[key]);
                    }
                }

            });
        }

    </script>
@stop
