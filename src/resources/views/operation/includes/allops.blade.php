<div class="box box-widget widget-user-2" style="padding: 3px;">
    <table class="table table-condensed table-hover table-responsive" id="calendar-allops">
        <thead class="bg-grey">
            <tr>
                <th data-priority="1"><i class="fa fa-hand-paper-o" aria-hidden="true"></i></th>
                <th data-priority="1">{{ trans('calendar::seat.title') }}</th>
                {{-- <th class="hidden-xs">{{ trans('calendar::seat.tags') }}</th> --}}
                {{-- <th>{{ trans('calendar::seat.importance') }}</th> --}}
                <th data-priority="1">{{ trans('calendar::seat.pap_count') }}</th>
                <th data-priority="2">{{ trans('calendar::seat.started_at') }}</th>
                <th data-priority="2">{{ trans('calendar::seat.fleet_commander') }}</th>
                {{-- <th>{{ trans('calendar::seat.staging') }}</th> --}}
                <th data-priority="2"></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div> 
