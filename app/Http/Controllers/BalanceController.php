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
        $date = $request->date_open .' '. $request->hour_open;
        $cashier = Cashier::first();
        $request->merge([
            'date_open' => str_replace('-', '/', $date),
            'cashier_id' => $cashier->id,
        ]);
        // dd($request->toArray());
        // var_dump($request->date_open);
        // dd(Carbon::rawCreateFromFormat('Y/m/d H:i', $request->date_open, NULL));
        // dd($date, request()->all());
        $balance = Balance::create($request->all());
        return response()->json([
            'msg' => 'Información guardada con éxito',
            'results' => [
                'date_open' => $balance->date_open->format('Y/m/d'),
                'hour_open' => $balance->date_open->format('H:i'),
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
        // this is same cashier and same balance? or balance from today.
        // dd(Balance::all()->toArray(), Carbon::now()->format('Y-m-d'));
        // $balance = Balance::where('date_open', Carbon::now('YY-mm-dd'));
        $balance = Balance::latest()->first();
        // dd($balance->toArray());
        // dd($balance->date_open->toTimeString());
        return response()->json([
            'status' => 'Success',
            'results' => [
                'date_open' => $balance->date_open->format('Y/m/d'),
                'hour_open' => $balance->date_open->format('H:i'),
                'value_previous_close' => $balance->value_previous_close,
                'value_open' => $balance->value_open,
                'observation' => $balance->observation,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function edit(Balance $balance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Balance $balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Balance $balance)
    {
        //
    }
}