<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 21/12/2017
 * Time: 14:24
 */

namespace Seat\Kassie\Calendar\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Seat\Kassie\Calendar\Models\Pap;
use Seat\Kassie\Calendar\Models\Sde\InvType;
use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Web\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CharacterController extends Controller {
    
    public function paps($character_id) {
        $today = carbon();
        if (! request()->ajax() ) {
            $monthlyPaps = Pap::where('character_id', $character_id)
                ->select('character_id', 'year', 'month', DB::raw('sum(value) as qty'))
                ->groupBy('year', 'month')
                ->get();

            $weeklyRanking = Pap::where('week', $today->weekOfMonth)
                            ->where('month', $today->month)
                            ->where('year', $today->year)
                            ->select('character_id', DB::raw('sum(value) as qty'))
                            ->groupBy('character_id')
                            ->orderBy('qty', 'desc')
                            ->get();

            $monthlyRanking = Pap::where('month', $today->month)
                            ->where('year', $today->year)
                            ->select('character_id', DB::raw('sum(value) as qty'))
                            ->groupBy('character_id')
                            ->orderBy('qty', 'desc')
                            ->get();

            $yearlyRanking = Pap::where('year', $today->year)
                            ->select('character_id', DB::raw('sum(value) as qty'))
                            ->groupBy('character_id')
                            ->orderBy('qty', 'desc')
                            ->get();

            return view('calendar::character.paps', compact('monthlyPaps', 'weeklyRanking', 'monthlyRanking', 'yearlyRanking', 'character_id'));
        } else {
            $division = request()->input('division');
            $character = CharacterInfo::findOrFail($character_id);
            $week = request()->input('week', $today->weekOfMonth);
            $month = request()->input('month', $today->month);
            $year = request()->input('year', $today->year);

            if ($division == 'weekly') {
                $weeklyRanking = Pap::join('character_infos', 'kassie_calendar_paps.character_id', 'character_infos.character_id')
                                    ->where('corporation_id', $character->corporation_id)
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
                                    ->where('corporation_id', $character->corporation_id)
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
                                    ->where('corporation_id', $character->corporation_id)
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

    // public function paps($character_id)
    // {
    //     $today = carbon();

    //     $monthlyPaps = Pap::where('character_id', $character_id)
    //         ->select('character_id', 'year', 'month', DB::raw('sum(value) as qty'))
    //         ->groupBy('year', 'month')
    //         ->get();

    //     $shipTypePaps = InvType::rightJoin('invGroups', 'invGroups.groupID', '=', 'invTypes.groupID')
    //         ->leftJoin('kassie_calendar_paps', 'ship_type_id', '=', 'typeID')
    //         ->where('categoryID', 6)
    //         ->where(function($query) use ($character_id) {
    //             $query->where('character_id', $character_id)
    //                 ->orWhere('character_id', null);
    //         })
    //         ->select('invGroups.groupID', 'categoryID', 'groupName', DB::raw('sum(value) as qty'))
    //         ->groupBy('invGroups.groupID')
    //         ->orderBy('groupName')
    //         ->get();

    //     $weeklyRanking = Pap::where('week', $today->weekOfMonth)
    //                      ->where('month', $today->month)
    //                      ->where('year', $today->year)
    //                      ->select('character_id', DB::raw('sum(value) as qty'))
    //                      ->groupBy('character_id')
    //                      ->orderBy('qty', 'desc')
    //                      ->get();

    //     $monthlyRanking = Pap::where('month', $today->month)
    //                       ->where('year', $today->year)
    //                       ->select('character_id', DB::raw('sum(value) as qty'))
    //                       ->groupBy('character_id')
    //                       ->orderBy('qty', 'desc')
    //                       ->get();

    //     $yearlyRanking = Pap::where('year', $today->year)
    //                      ->select('character_id', DB::raw('sum(value) as qty'))
    //                      ->groupBy('character_id')
    //                      ->orderBy('qty', 'desc')
    //                      ->get();

    //     return view('calendar::character.paps', compact('monthlyPaps', 'shipTypePaps',
    //         'weeklyRanking', 'monthlyRanking', 'yearlyRanking', 'character_id'));
    // }

}
