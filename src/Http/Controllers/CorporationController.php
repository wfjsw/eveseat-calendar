<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 03/01/2018
 * Time: 11:08
 */

namespace Seat\Kassie\Calendar\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Seat\Kassie\Calendar\Models\Pap;
use Seat\Web\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CorporationController extends Controller {

    public function getPaps(int $corporation_id) {
        $today = carbon();
        if (! request()->ajax() ) {
            return view('calendar::corporation.paps');
        } else {
            $division = request()->input('division');
            $week = request()->input('week', $today->weekOfMonth);
            $month = request()->input('month', $today->month);
            $year = request()->input('year', $today->year);

            if ($division == 'weekly') {
                $weeklyRanking = Pap::join('character_infos', 'kassie_calendar_paps.character_id', 'character_infos.character_id')
                                    ->where('corporation_id', $corporation_id)
                                    ->where('week', $week)
                                    ->where('month', $month)
                                    ->where('year', $year)
                                    ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY sum(value) DESC) AS identifier'), 'kassie_calendar_paps.character_id', DB::raw('sum(value) as qty'))
                                    ->groupBy('character_id')
                                    ->orderBy('qty', 'desc')
                                    ->get();

                return DataTables::of($weeklyRanking)
                    ->editColumn('character_id', function ($row) {
                        return view('calendar::partials.character', ['character' => $row->character]);
                    })
                    ->rawColumns(['character_id'])
                    ->make(true);
            } else if ($division == 'monthly') {
                $monthlyRanking = Pap::join('character_infos', 'kassie_calendar_paps.character_id', 'character_infos.character_id')
                                    ->where('corporation_id', $corporation_id)
                                    ->where('month', $month)
                                    ->where('year', $year)
                                    ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY sum(value) DESC) AS identifier'), 'kassie_calendar_paps.character_id', DB::raw('sum(value) as qty'))
                                    ->groupBy('character_id')
                                    ->orderBy('qty', 'desc')
                                    ->get();
                
                return DataTables::of($monthlyRanking)
                    ->editColumn('character_id', function ($row) {
                        return view('calendar::partials.character', ['character' => $row->character]);
                    })
                    ->rawColumns(['character_id'])
                    ->make(true);
            } else if ($division == 'yearly') {
                $yearlyRanking = Pap::join('character_infos', 'kassie_calendar_paps.character_id', 'character_infos.character_id')
                                    ->where('corporation_id', $corporation_id)
                                    ->where('year', $year)
                                    ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY sum(value) DESC) AS identifier'), 'kassie_calendar_paps.character_id', DB::raw('sum(value) as qty'))
                                    ->groupBy('character_id')
                                    ->orderBy('qty', 'desc')
                                    ->get();
                
                return DataTables::of($yearlyRanking)
                    ->editColumn('character_id', function ($row) {
                        return view('calendar::partials.character', ['character' => $row->character]);
                    })
                    ->rawColumns(['character_id'])
                    ->make(true);
            } else {
                return [];
            }
        }
    }

    // public function getPaps(int $corporation_id)
    // {
	//     $today = carbon();

	//     $weeklyRanking = Pap::join('character_infos', 'kassie_calendar_paps.character_id', 'character_infos.character_id')
	//                         ->where('corporation_id', $corporation_id)
	//                         ->where('week', $today->weekOfMonth)
	//                         ->where('month', $today->month)
	//                         ->where('year', $today->year)
	//                         ->select('kassie_calendar_paps.character_id', DB::raw('sum(value) as qty'))
	//                         ->groupBy('character_id')
	//                         ->orderBy('qty', 'desc')
	//                         ->get();

	//     $monthlyRanking = Pap::join('character_infos', 'kassie_calendar_paps.character_id', 'character_infos.character_id')
	//                          ->where('corporation_id', $corporation_id)
	//                          ->where('month', $today->month)
	//                          ->where('year', $today->year)
	//                          ->select('kassie_calendar_paps.character_id', DB::raw('sum(value) as qty'))
	//                          ->groupBy('character_id')
	//                          ->orderBy('qty', 'desc')
	//                          ->get();

	//     $yearlyRanking = Pap::join('character_infos', 'kassie_calendar_paps.character_id', 'character_infos.character_id')
	//                         ->where('corporation_id', $corporation_id)
	//                         ->where('year', $today->year)
	//                         ->select('kassie_calendar_paps.character_id', DB::raw('sum(value) as qty'))
	//                         ->groupBy('character_id')
	//                         ->orderBy('qty', 'desc')
	//                         ->get();

    //     return view('calendar::corporation.paps', compact('weeklyRanking', 'monthlyRanking', 'yearlyRanking'));
    // }

    // public function getYearPapsStats(int $corporation_id)
    // {
    //     $year = request()->query('year');
    //     $grouped = request()->query('grouped');

    //     if (is_null($year))
    //         $year = carbon()->year;

    //     if (is_null($grouped))
    //         $grouped = false;

    //     if (! $grouped)
    //         return response()->json(
    //             Pap::where('year', intval($year))
    //                ->where('corporation_id', $corporation_id)
    //                ->leftJoin('character_infos', 'character_infos.character_id', 'kassie_calendar_paps.character_id')
    //                ->select('kassie_calendar_paps.character_id', 'name', DB::raw('sum(value) as qty'))
    //                ->groupBy('kassie_calendar_paps.character_id', 'name')
    //                ->orderBy('qty', 'desc')
    //                ->orderBy('name', 'asc')
    //                ->get());

    //     return response()->json(
    //         Pap::where('year', intval($year))
    //             ->where('corporation_id', $corporation_id)
    //             ->select('ci.character_id', 'ci.name', DB::raw('sum(value) as qty'))
    //             ->join('character_infos as ci', 'ci.character_id', 'kassie_calendar_paps.character_id')
    //             ->join('users', 'ci.character_id', 'users.id')
    //             ->groupBy('group_id')
    //             ->orderBy('qty', 'desc')
	//             ->orderBy('name', 'asc')
    //             ->get());
    // }

    // public function getMonthlyStackedPapsStats(int $corporation_id)
    // {
    //     $year = is_null(request()->query('year')) ? carbon()->year : intval(request()->query('year'));
    //     $month = is_null(request()->query('month')) ? carbon()->year : intval(request()->query('month'));
    //     $grouped = request()->query('grouped') ?: false;

    //     $paps = Pap::select('ci.character_id', 'ci.name', 'cto.operation_id', 'analytics', 'value')
    //                ->join('character_infos as ci', 'kassie_calendar_paps.character_id', 'ci.character_id')
    //                ->join('calendar_tag_operation as cto', 'cto.operation_id', 'kassie_calendar_paps.operation_id')
    //                ->join('calendar_tags as ct', 'ct.id', 'cto.tag_id')
    //                ->where('year', $year)
    //                ->where('month', $month)
    //                ->where('corporation_id', $corporation_id);

    //     if ($grouped)
	//         $paps = $paps->join('users', 'users.id', 'ci.character_id')
	//                      ->groupBy('group_id', 'cto.operation_id', 'analytics');
    //     else
	//         $paps = $paps->groupBy('ci.character_id', 'cto.operation_id', 'analytics');

    //     return response()->json(
    //     	DB::table(DB::raw("({$paps->toSql()}) as paps"))
	// 	        ->mergeBindings($paps->getQuery())
	// 	        ->select('analytics', 'character_id', 'name', DB::raw('sum(value) as qty'))
	// 	        ->groupBy('character_id', 'name', 'analytics')
    //             ->orderBy('qty', 'desc')
    //             ->orderBy('name', 'asc')
    //             ->get());
    // }
}
