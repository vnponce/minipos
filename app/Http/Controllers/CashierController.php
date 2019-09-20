<?php

namespace App\Http\Controllers;

use App\Cashier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashierController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        // dd($request->date_open);
        [$year, $month, $day] = explode('/', $request->date_open);
        [$hours, $minutes] = explode(':', $request->hour_open);
        // Next line would help if we need to set a default value in case that _hour_open_ var has seconds section.
        // [$hours, $minutes, $seconds] = array_pad(explode(':', $request->hour_open), 3, 0);
        $date = Carbon::create($year, $month, $day, $hours, $minutes);

        $response = [
            "msg" =>"Información guardada con éxito",
            "results" => [
                "date_open" => "2019/06/11",
                "hour_open" => "12:45",
                "value_previous_close" => 6280,
                "value_open" => 100,
                "observation" => ""
            ],
        ];
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function show(Cashier $cashier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashier $cashier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cashier $cashier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashier $cashier)
    {
        //
    }
}
