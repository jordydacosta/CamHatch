@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @yield('page-header')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover custom_datatable_layout" id="reviews-table">
                            <thead>
                            <tr>
                                <th class="col-md-2">{{trans('general.name')}}</th>
                                <th class="col-md-1">{{trans('general.rating')}}</th>
                                <th class="col-md-3">{{trans('general.description_dutch')}}</th>
                                <th class="col-md-3">{{trans('general.description_english')}}</th>
                                <th class="col-md-2 text-right">{{trans('general.created_at')}}</th>
                                <th class="col-md-1">{{trans('general.actions')}}</th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    {!! \Helpers::showModal("You are about to delete this review, are you sure you want to do this?", "Everything concerning this review will be lost!") !!}
@stop

@section('javascript')
    <script type="text/javascript">

        var oTable;

        $(document).ready(function() {
            oTable = $('#reviews-table').DataTable({
                "sPaginationType": "simple_numbers",
                "bLengthChange": false, // disable results per page
                "bProcessing": true,
                "bServerSide": true,
                "bFilter": true,
                "bInfo": true,
                "sAjaxSource": '{!! route('reviews_data') !!}',
                "fnDrawCallback": function(oSettings) {
                    $('.remove_review').on('click', function() {
                        review_id = $(this).data('id');
                        $("#myModal").modal('show');
                    });

                    $('button.state_review').on('click', function() {
                        changeState($(this).data('id'), $(this).data('state'));
                    });
                },
                "aaSorting": [[0, "asc"]], // default sorting on column 3
                "aoColumns": [
                    {"data": "name"},
                    {"data": "rating"},
                    {"data": "description"},
                    {"data": "description_en"},
                    {"data": "created_at"},
                    {"data": "actions", "bSortable": false} // disable sorting for last column
                ]
            });

            /**
             * Delete the selected review
             */
            $("#submit_modal_delete").click(function() {
                deleteResource("{{{ route('reviews') }}}/" + review_id, {}, oTable);
            });
        });

        function changeState(id, current_state) {
            let new_state = 0;

            if (current_state == 0)
                new_state = 1;

            // build URL
            var url = "{{{ route('reviews') }}}/state/" + id;

            handleAjaxRequests(url, {'state': new_state}, 'PUT').done(function(data) {
                if (data.changed == 1) {
                    oTable.ajax.reload(null, false);
                }
            });
        }

    </script>
@stop
