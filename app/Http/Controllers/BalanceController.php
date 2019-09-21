<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Cashier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BalanceController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get this cuz I'm not sure if this is a dynamic parameter
        $cashier = Cashier::first();

        $date = $request->date_open .' '. $request->hour_open;
        $request->merge([
            'date_open' => str_replace('/', '-', $date),
            'cashier_id' => $cashier->id,
        ]);

        $balance = Balance::create($request->all());
        return response()->json([
            'msg' => 'Información guardada con éxito',
            'results' => [
                'date_open' => $balance->date_open->format('Y/m/d'),
                'hour_open' => $balance->date_open->format('H:i:s'),
                'value_previous_close' => $balance->value_previous_close,
                'value_open' => $balance->value_open,
                'observation' => $balance->observation ?? '',
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function show(Balance $balance)
    {
        // this is same cashier and same balance? or balance from today?.
        $balance = Balance::latest()->first();
        return response()->json([
            'status' => 'Success',
            'results' => [
                'date_open' => $balance->date_open->format('Y/m/d'),
                'hour_open' => $balance->date_open->format('H:i:s'),
                'value_previous_close' => $balance->value_previous_close,
                'value_open' => $balance->value_open,
                'observation' => $balance->observation,
            ]
        ]);
    }
}
