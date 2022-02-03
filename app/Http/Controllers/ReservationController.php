<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required',
            'data.user_ids.*' => 'required|max:8|distinct:strict',
            'data.reservation_datetime.*' => 'required|numeric|min:1000000000|max:900000000000',
        ]);

        $completeData = $request->input('data');
        $user_ids = $completeData['user_ids'];
        $incoming_datetime = $completeData['reservation_datetime'][0];

        $group_size = count($user_ids);

        $current_setting = \DB::table('restriction_settings')->find(1);


        switch ($current_setting->d) {
            case 'day':
                $previousReservationsOfSameDay = \DB::table('reservations')
                                            ->whereIn('user_id',$user_ids)
                                            ->where('reservation_timestamp_utc','<=',$incoming_datetime)
                                            ->where('reservation_timestamp_utc','>',$incoming_datetime - 24*60*60)
                                            ->orderBy('reservation_timestamp_utc','desc');
                
                // Clone the query to keep the original query intact
                // $latest_reservation = $previousReservationsOfSameDay->clone()->limit(1);
                $numberOfPreviousReservations = $previousReservationsOfSameDay->count();

                if( $numberOfPreviousReservations >= 0 
                    && $numberOfPreviousReservations < $current_setting->n) {
                    for($i=0; $i<$group_size; $i++){
                        Reservation::insert([
                            'user_id' => $user_ids[$i], 
                            'reservation_timestamp_utc' => $incoming_datetime,
                        ]);
                    }
                } else {
                    return response()->json(
                        [
                        'success' => false,
                        'message' => 'Reservation limit exceeded'
                        ]
                    );
                }
                break;
            case 'week':
                $previousReservationsOfSameWeek = \DB::table('reservations')
                                    ->where('user_id',$user_ids[0])
                                    ->where('reservation_timestamp_utc','<=',$incoming_datetime)
                                    ->where('reservation_timestamp_utc','>',$incoming_datetime - 7*24*60*60)
                                    ->orderBy('reservation_timestamp_utc','desc');

                // Clone the query to keep the original query intact
                // $latest_reservation = $previousReservationsOfSameDay->clone()->limit(1);
                $numberOfPreviousReservations = $previousReservationsOfSameWeek->count();

                if( $numberOfPreviousReservations >= 0 
                && $numberOfPreviousReservations < $current_setting->n) {
                    for($i=0; $i<$group_size; $i++){
                        Reservation::insert([
                            'user_id' => $user_ids[$i], 
                            'reservation_timestamp_utc' => $incoming_datetime,
                        ]);
                    }
                } else {
                    return response()->json(
                            [
                            'success' => false,
                            'message' => 'Reservation limit exceeded'
                            ]
                        );
                    }
                break;
            case 'month':
                $previousReservationsOfSameMonth = \DB::table('reservations')
                                    ->where('user_id',$user_ids[0])
                                    ->where('reservation_timestamp_utc','<=',$incoming_datetime)
                                    ->where('reservation_timestamp_utc','>',$incoming_datetime - 30*24*60*60)
                                    ->orderBy('reservation_timestamp_utc','desc');

                // Clone the query to keep the original query intact
                // $latest_reservation = $previousReservationsOfSameDay->clone()->limit(1);
                $numberOfPreviousReservations = $previousReservationsOfSameMonth->count();

                if( $numberOfPreviousReservations >= 0 
                && $numberOfPreviousReservations < $current_setting->n) {
                    for($i=0; $i<$group_size; $i++){
                        Reservation::insert([
                            'user_id' => $user_ids[$i], 
                            'reservation_timestamp_utc' => $incoming_datetime,
                        ]);
                    }
                } else {
                    return response()->json(
                        [
                        'success' => false,
                        'message' => 'Reservation limit exceeded'
                        ]
                    );
                }
                break;
            default:
                break;
            }

    
        return response()->json(
            [
            'success' => false,
            'message' => 'Reservation made successfully'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function modifySetting(Request $request) {

        $validated = $request->validate([
            'data.n' => 'required|numeric|max:1000',
            'data.d' => 'required|in:day,week,month',
            'data.g' => 'required|in:individual,group',
            'data.tz' => 'required|in:UTC,Asia/Kolkata,America/NewYork',
        ]);

        $completeData = $request->input('data');
        $n = $completeData['n'];
        $d = $completeData['d'];
        $g = $completeData['g'];
        $tz = $completeData['tz'];

        $setting = \DB::table('restriction_settings')->find(1);


        //Create a setting if table is empty
        if($setting==null){
            \DB::table('restriction_settings')->where('id',1)->insert(
                [
                    "id" => 1,
                    "n" => $n,
                    "d" => $d,
                    "g" => $g,
                    "tz" => $tz,
                ]
        );
        }

        //Else update the setting
        \DB::table('restriction_settings')->where('id',1)->update(
                [
                    "n" => $n,
                    "d" => $d,
                    "g" => $g,
                    "tz" => $tz,
                ]
        );
        
        return response()->json(
            [
            'success' => true,
            'message' => 'Reservation setting modified'
            ]
        );
    }
}
