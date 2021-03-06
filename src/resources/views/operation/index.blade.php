@extends('web::layouts.grids.12')

@section('title', trans('calendar::seat.plugin_name') . ' | ' . trans('calendar::seat.operations'))
@section('page_header', trans('calendar::seat.all_operations'))

@section('full')

    @if(auth()->user()->has('calendar.create', false))
    <div class="row margin-bottom">
        <div class="col-md-offset-8 col-md-4">
            <div class="pull-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreateOperation">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;
                    {{ trans('calendar::seat.add_operation') }}
                </button>
            </div>
        </div>
    </div>
    @endif

    @include('calendar::operation.includes.modals.create_operation')
    @include('calendar::operation.includes.modals.update_operation')
    @include('calendar::operation.includes.modals.confirm_delete')
    @include('calendar::operation.includes.modals.confirm_close')
    @include('calendar::operation.includes.modals.confirm_cancel')
    @include('calendar::operation.includes.modals.confirm_activate')
    {{-- @include('calendar::operation.includes.modals.subscribe') --}}
    @include('calendar::operation.includes.modals.manual_record')
    @include('calendar::operation.includes.modals.details')

    <div class="row">
        <div class="col-md-12">
            @include('calendar::operation.includes.allops')
        </div>
    </div>

@stop

@push('head')
    <link rel="stylesheet" href="{{ asset('web/css/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap-slider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('web/css/calendar.css') }}" />
@endpush

@push('javascript')
    <script src="{{ asset('web/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('web/js/natural.js') }}"></script>
    <script src="{{ asset('web/js/calendar.js') }}"></script>
    @include('web::includes.javascript.id-to-name')
    <script type="text/javascript">
        $('#calendar-allops').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            responsive: true,
            ajax: {
                url: '{{ route('operation.allops') }}'
            },
            pageLength: 50,
            lengthChange: true,
            lengthMenu: [ 15, 30, 50, 75, 100, 200, 300 ],
            // dom: 'rt<"col-sm-5"i><"col-sm-7"p>',
            columns: [
                {data: 'participated', name: 'participated', searchable: false, orderable: false, responsivePriority: 1, render: (data) => data ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-times text-danger" aria-hidden="true"></i>' },
                {data: 'title', name: 'title', responsivePriority: 1},
                // {data: 'tags', name: 'tags', orderable: false},
                // {data: 'importance', name: 'importance'},
                {data: 'pap_count', name: 'pap_count', responsivePriority: 1},
                {data: 'start_at', name: 'start_at', responsivePriority: 2},
                // {data: 'end_at', name: 'end_at'},
                {data: 'fleet_commander', name: 'fleet_commander', orderable: false, responsivePriority: 2},
                // {data: 'staging_sys', name: 'staging_sys'},
                // {data: 'subscription', name: 'subscription', orderable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false, responsivePriority: 2}
            ],
            order: [
                [3, 'desc']
            ],
            drawCallback: function () {
                // enable tooltip
                $('[data-toggle="tooltip"]').tooltip();

                
                $('.pap-btn').on('click', function (e) {
                    if (e.ctrlKey) {
                        e.preventDefault();
                        var op_id = $(this).attr('data-op-id');
                        $('#modalManualRecord').find('#operation-id').val(op_id);
                        $('#modalManualRecord').find('#names-list').val('');
                        $('#modalManualRecord').modal('show');
                    }
                });

                // resolve EVE ids to names.
                ids_to_names();
            }
        });

        $('#modalDetails')
            .on('show.bs.modal', function(e){
                var link = '{{ route('operation.detail', 0) }}';
                // load detail content dynamically
                $(this).find('.modal-body')
                    .html('Loading...')
                    .load(link.replace(/0$/gi, $(e.relatedTarget).attr('data-op-id')), "", function(){
                        // attach the datatable to the loaded modal
                        // var attendees_table = $('#attendees');
                        var confirmed_table = $('#confirmed');

                        // if (! $.fn.DataTable.isDataTable(attendees_table)) {
                        //     attendees_table.DataTable({
                        //         "ajax": "/calendar/lookup/attendees?id=" + $(e.relatedTarget).attr('data-op-id'),
                        //         "ordering": true,
                        //         "info": false,
                        //         "paging": true,
                        //         "processing": true,
                        //         "order": [[ 1, "asc" ]],
                        //         "aoColumnDefs": [
                        //             { orderable: false, targets: "no-sort" }
                        //         ],
                        //         "columns": [
                        //             { data: '_character' },
                        //             { data: '_status' },
                        //             { data: '_comment' },
                        //             { data: '_timestamps' }
                        //         ],
                        //         createdRow: function(row, data, dataIndex) {
                        //             $(row).find('td:eq(0)').attr('data-order', data._character_name);
                        //             $(row).find('td:eq(0)').attr('data-search', data._character_name);
                        //         }
                        //     });
                        // }

                        if (! $.fn.DataTable.isDataTable(confirmed_table)) {
                            confirmed_table.DataTable({
                                "ajax": "/calendar/lookup/confirmed?id=" + $(e.relatedTarget).attr('data-op-id'),
                                "ordering": true,
                                "info": false,
                                "paging": true,
                                "processing": true,
                                "order": [[ 1, "asc" ]],
                                "aoColumnsDefs": [
                                    { orderable: false, targets: "no-sort" }
                                ],
                                'fnDrawCallback': function () {
                                    $(document).ready(function () {
                                        ids_to_names();
                                    });
                                },
                                "columns": [
                                    { data: 'character.character_id'},
                                    { data: 'character.corporation_id'},
                                @if(auth()->user()->has('calendar.create', false))
                                    { data: 'type.typeID'},
                                    { data: 'type.group.groupName'},
                                @endif
                                ],
                                createdRow: function(row, data, dataIndex) {
                                    $(row).find('td:eq(0)').attr('data-order', data.character.character_id);
                                    $(row).find('td:eq(0)').attr('data-search', data.character.character_id);
                                }
                            });
                        }
                    });
            })
            .on('hidden.bs.modal', function(e) {
                var table = $(this).find('#confirmed').DataTable();
                table.destroy();
            });

        // direct link
        $(function(){
            if ($('tr[data-attr-default=true]').length > 0)
                $('tr[data-attr-default]').find('.hidden-xs').find('.fa-eye').click();
        });
    </script>
@endpush
