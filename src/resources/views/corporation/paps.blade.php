@extends('web::corporation.layouts.view', ['viewname' => 'paps'])

@section('title', trans_choice('web::seat.corporation', 1) . ' ' . trans('calendar::seat.paps'))
@section('page_header', trans_choice('web::seat.corporation', 1) . ' ' . trans('calendar::seat.paps'))

@inject('request', 'Illuminate\Http\Request')

@section('corporation_content')
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">{{ trans('calendar::seat.paps') }}</h3>
    </div>
    <div class="panel-body">
    {{--    <h3>Stats</h3>
        <div class="row">
            <div class="col-sm-4">
                <div class="input-group input-group-sm" id="yearChartSettings">
                    <span class="input-group-addon">
                        <input type="checkbox" name="grouped" />
                        <b>Use people groups settings ?</b>
                    </span>
                    <input type="text" name="year" class="form-control" value="{{ carbon()->year }}" placeholder="year" />
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat">Display</button>
                    </span>
                </div>
            </div>
            <div class="chart">
                <canvas id="yearPaps" height="200" width="900"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="input-group input-group-sm" id="monthlyStackedChartSettings">
                    <span class="input-group-addon">
                        <input type="checkbox" name="grouped" />
                        <b>Use people groups settings ?</b>
                    </span>
                    <select name="month" class="form-control">
                        @for($i = 1; $i < 13; $i++)
                        <option value="{{ $i }}" @if($i == carbon()->month)selected="selected"@endif>{{ $i }}</option>
                        @endfor
                    </select>
                    <input type="text" name="year" class="form-control" value="{{ carbon()->year }}" placeholder="year" />
                    <span class="input-group-addon">
                        <button type="button" class="btn btn-info btn-flat">Display</button>
                    </span>
                </div>
            </div>
            <div class="chart">
                <canvas id="monthlyStackedChart" width="900"></canvas>
            </div>
        </div> --}}
        {{-- <div class="row">
            <div class="col-md-12">
                <h3>Ranking</h3>
                <div class="col-md-4">
                    <h4>This week</h4>
                    <table class="table table-striped @if($weeklyRanking->count() > 0) ranking-table @endif">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Character</th>
                                <th>Paps</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($weeklyRanking as $pap)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{!! img('character', $pap->character_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!} {{ $pap->character->name }}</td>
                                <td>{{ $pap->qty }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">There are no paps for the current week.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <h4>This month</h4>
                    <table class="table table-striped @if($monthlyRanking->count() > 0) ranking-table @endif">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Character</th>
                            <th>Paps</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($monthlyRanking as $pap)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{!! img('character', $pap->character_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!} {{ $pap->character->name }}</td>
                                <td>{{ $pap->qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">There are no paps for the current week.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <h4>This year</h4>
                    <table class="table table-striped @if($yearlyRanking->count() > 0) ranking-table @endif">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Character</th>
                            <th>Paps</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($yearlyRanking as $pap)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{!! img('character', $pap->character_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!} {{ $pap->character->name }}</td>
                                <td>{{ $pap->qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">There are no paps for the current week.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
        
        <div class="row">
            <div class="col-md-12">
                <h3>Ranking</h3>
                <div class="col-md-4">
                    <h4>Week 
                        <select id="pap-rank-week">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </h4>
                    <table id="weekly-rank" class="table table-striped ranking-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Character</th>
                                <th>Paps</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <h4>Month
                        <select id="pap-rank-month">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </h4>
                    <table id="monthly-rank" class="table table-striped ranking-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Character</th>
                            <th>Paps</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <h4>Year
                        <input type="number" id="pap-rank-year" min="1970" max="2099">
                    </h4>
                    <table id="yearly-rank" class="table table-striped ranking-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Character</th>
                            <th>Paps</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('javascript')
{{-- <script type="text/javascript" src="{{ asset('web/js/rainbowvis.js') }}"></script> --}}
<script type="text/javascript">
$(function(){
    {{-- /* var yearChart, monthChart;
    var rainbow = new Rainbow();
    var yearChartParameters = $('#yearChartSettings');
    var monthChartParameters = $('#monthlyStackedChartSettings');
    var themeColor = rgb2hex($('nav.navbar').css('backgroundColor'));

    // just in case we're on white paper, reverse color
    if (themeColor.substr(4) === rgb2hex($('.panel').css('backgroundColor')).substr(4))
        themeColor = '#000000';

    var yearChartSettings = {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                type: 'line',
                label: '% participation',
                data: [],
                yAxisID: 'pareto',
                fill: false
            },{
                type: 'bar',
                label: '# participation',
                data: [],
                backgroundColor: [],
                yAxisID: 'quantity'
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'participation of year'
            },
            tooltips: {
                mode: 'index',
                intersect: true
            },
            scales: {
                xAxes: [{
                    barThickness: 20
                }],
                yAxes: [{
                    id: 'quantity',
                    ticks: {
                        min: 0,
                        stepSize: 1
                    },
                    position: 'left'
                }, {
                    id: 'pareto',
                    ticks: {
                        min: 0
                    },
                    gridLines: {
                        drawOnChartArea: false
                    },
                    position: 'right'
                }]
            }
        }
    };

    var monthChartSettings = {
        type: 'horizontalBar',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            title: {
                display: true,
                text: 'stacked participation of the month'
            },
            scales: {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    stacked: true,
                    barThickness: 20
                }]
            }
        }
    };

    $('.ranking-table').DataTable({
        'dom':'<"toolbar">frtip',
        'order': [[0, 'asc']]
    });

    yearChartParameters.find('button').on('click', function(){
        $.ajax({
            url: '{{ route('corporation.ajax.paps.year', request()->route('corporation_id')) }}',
            data: {
                year: yearChartParameters.find('input[type="text"]').val(),
                grouped: yearChartParameters.find('input[type="checkbox"]').is(':checked') ? 1 : 0
            },
            success: function(data){
                var pareto = [];

                if (typeof yearChart !== 'undefined')
                    yearChart.destroy();

                yearChartSettings.data.labels = [];
                yearChartSettings.data.datasets[0].data = [];
                yearChartSettings.data.datasets[1].data = [];
                yearChartSettings.data.datasets[1].backgroundColor = [];
                $('#yearPaps')
                    .parent('.chart')
                    .find('p')
                    .remove();

                if (data.length < 1) {
                    $('#yearPaps')
                        .parent('.chart')
                        .append('<p class="text-danger text-center">There are no data to display</p>');
                    return;
                }

                rainbow.setNumberRange(0, data.length);
                rainbow.setSpectrum('#8e8e8e', themeColor, '#dddddd');

                $(data).each(function (index, record) {
                    yearChartSettings.data.labels.push((record.name == null) ? 'Unknown' : record.name);
                    yearChartSettings.data.datasets[1].data.push(record.qty);

                    if (pareto.length > 0)
                        pareto.push(pareto[pareto.length - 1] + parseFloat(record.qty));
                    else
                        pareto.push(parseFloat(record.qty));

                    yearChartSettings.data.datasets[1].backgroundColor.push('#' + rainbow.colourAt(index))
                });

                $(pareto).each(function (index, value) {
                    yearChartSettings.data.datasets[0].data.push(value / pareto[pareto.length - 1] * 100);
                });

                yearChartSettings.options.title.text = 'participation of year ' + yearChartParameters
                    .find('input[type="text"]')
                    .val();

                if (yearChartParameters.find('input[type="checkbox"]').is(':checked'))
                    yearChartSettings.options.title.text = 'grouped ' + yearChartSettings.options.title.text;

                yearChart = new Chart(document.getElementById('yearPaps').getContext('2d'), yearChartSettings);
            }
        });
    });

    monthChartParameters.find('button').on('click', function(){
        $.ajax({
            url: '{{ route('corporation.ajax.paps.stacked', request()->route('corporation_id')) }}',
            data: {
                year: monthChartParameters.find('input[name="year"]').val(),
                month: monthChartParameters.find('select[name="month"]').val(),
                grouped: monthChartParameters.find('input[type="checkbox"]').is(':checked') ? 1 : 0
            },
            success: function(data){

                var pointFound = false;
                var seriesFound = false;
                var datasetLabels = [];
                var series = [];

                if (typeof(monthChart) !== 'undefined')
                    monthChart.destroy();

                monthChartSettings.data.labels = [];
                monthChartSettings.data.datasets = [];

                $('#monthlyStackedChart')
                    .parent('.chart')
                    .find('p')
                    .remove();

                if (data.length < 1) {
                    $('#monthlyStackedChart')
                        .parent('.chart')
                        .append('<p class="text-danger text-center">There are no data to display</p>');
                    return;
                }

                $(data).each(function(index, record){
                    pointFound = false;
                    seriesFound = false;

                    if ($.inArray(record.name, monthChartSettings.data.labels) < 0)
                        monthChartSettings.data.labels.push(record.name);

                    if ($.inArray(record.analytics, datasetLabels) < 0) {
                        datasetLabels.push(record.analytics);
                        monthChartSettings.data.datasets.push({
                            label: record.analytics,
                            data: []
                        });
                    }

                    $(series).each(function(index, serie){
                        if (serie.label === record.name) {
                            seriesFound = true;

                            $(serie.points).each(function(index, point){
                                if (point.name === record.analytics) {
                                    pointFound = true;
                                    point.value += parseFloat(record.qty);
                                }
                            });

                            if (!pointFound)
                                serie.points.push({
                                    name: record.analytics,
                                    value: parseFloat(record.qty)
                                });
                        }
                    });

                    if (!seriesFound)
                        series.push({
                            label: record.name,
                            points: [{
                                name: record.analytics,
                                value: record.qty
                            }]
                        });
                });

                rainbow.setNumberRange(0, monthChartSettings.data.datasets.length);
                rainbow.setSpectrum(themeColor, '#dddddd');

                $(monthChartSettings.data.labels).each(function(labelIndex, label) {
                    pointFound = false;

                    $(monthChartSettings.data.datasets).each(function (datasetIndex, dataset) {
                        dataset.backgroundColor = '#' + rainbow.colourAt(datasetIndex);

                        $(series[labelIndex].points).each(function(pointIndex, point){
                            if (point.name === dataset.label){
                                pointFound = true;
                                dataset.data.push(parseFloat(point.value));
                            }
                        });

                        if (!pointFound)
                            dataset.data.push(0.0);
                    });
                });

                monthChartSettings.options.title.text = 'participation of ' + monthChartParameters
                    .find('select[name="month"]')
                    .val() + '-' + monthChartParameters
                    .find('input[name="year"]')
                    .val();

                if (monthChartParameters.find('input[type="checkbox"]').is(':checked'))
                    monthChartSettings.options.title.text = 'grouped ' + monthChartSettings.options.title.text;

                console.debug(series);
                console.debug(monthChartSettings);

                monthChart = new Chart(document.getElementById('monthlyStackedChart').getContext('2d'), monthChartSettings);
            }
        });
    });

    yearChartParameters.find('button').click();
    monthChartParameters.find('button').click(); */ --}}

    const now = new Date()

    $('#pap-rank-week').val(Math.ceil(now.getUTCDate() / 7))
    $('#pap-rank-month').val(now.getUTCMonth() + 1)
    $('#pap-rank-year').val(now.getUTCFullYear())

    const tweeklyrank = window.tweeklyrank = $('table#weekly-rank').DataTable({
        processing: true,
        serverSide: false,
        ordering: false,
        lengthChange: false,
        pageLength: 10,
        searchDelay: 300,
        dom: '<\'row\'<\'col-sm-6\'f>><\'row\'<\'col-sm-12\'tr>><\'row\'<\'col-sm-12\'i><\'col-sm-12\'p>>',
        columns: [
            {data: 'identifier', name: 'identifier'},
            {data: 'character_id', name: 'character_id'},
            {data: 'qty', name: 'qty'}
        ],
        ajax: {
            url: '{{url()->current()}}',
            data: (d) => {
                d.division = 'weekly'
                d.week = $('#pap-rank-week').val()
                d.month = $('#pap-rank-month').val()
                d.year = $('#pap-rank-year').val()
            }
        }
    })

    const tmonthlyrank = window.tmonthlyrank = $('table#monthly-rank').DataTable({
        processing: true,
        serverSide: false,
        ordering: false,
        lengthChange: false,
        pageLength: 10,
        searchDelay: 300,
        dom: '<\'row\'<\'col-sm-6\'f>><\'row\'<\'col-sm-12\'tr>><\'row\'<\'col-sm-12\'i><\'col-sm-12\'p>>',
        columns: [
            {data: 'identifier', name: 'identifier'},
            {data: 'character_id', name: 'character_id'},
            {data: 'qty', name: 'qty'}
        ],
        ajax: {
            url: '{{url()->current()}}',
            data: (d) => {
                d.division = 'monthly'
                d.month = $('#pap-rank-month').val()
                d.year = $('#pap-rank-year').val()
            }
        }
    })

    const tyearlyrank = window.tyearlyrank = $('table#yearly-rank').DataTable({
        processing: true,
        serverSide: false,
        ordering: false,
        lengthChange: false,
        pageLength: 10,
        searchDelay: 300,
        dom: '<\'row\'<\'col-sm-6\'f>><\'row\'<\'col-sm-12\'tr>><\'row\'<\'col-sm-12\'i><\'col-sm-12\'p>>',
        columns: [
            {data: 'identifier', name: 'identifier'},
            {data: 'character_id', name: 'character_id'},
            {data: 'qty', name: 'qty'}
        ],
        ajax: {
            url: '{{url()->current()}}',
            data: (d) => {
                d.division = 'yearly'
                d.year = $('#pap-rank-year').val()
            }
        }
    })

    $('#pap-rank-week, #pap-rank-month, #pap-rank-year').on('change', function () {
        window.tweeklyrank.ajax.reload()
        window.tmonthlyrank.ajax.reload()
        window.tyearlyrank.ajax.reload()
    })

    function rgb2hex(rgb) {
        try {
            rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
            return (rgb && rgb.length === 4) ? "#" +
                ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
                ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
                ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : '';
        } catch (e) {
            return rgb;
        }
    }
});
</script>
@endpush
