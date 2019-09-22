<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Cashier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BalanceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Get this cuz I'm not sure if this is a dynamic parameter
        $cashier = Cashier::first();

        $request->merge([
            'date_open' => formatBalanceOpenDate($request),
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
                'observation' => $balance->observation,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Balance $balance
     * @return Response
     */
    public function show(Balance $balance)
    {
        // this is same cashier always? also same balance? or balance from today?.
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

    /**
     * Display open cashier balance.
     *
     * @param Balance $balance
     * @return Response
     */
    public function hasOpen(Balance $balance)
    {
        $balance = Balance::latest()->first();
        if ($balance->value_open === null) {
            return response()->json([
                'msg' => 'No se puede mostrar esta información',
            ]);
        }
        return response()->json([
            'msg' => 'Success',
            'results' => true,
            'value' => $balance->value_open,
            'close' => $balance->close,
            'card' => $balance->card,
        ]);
    }

    /**
     * Store close cashier balance.
     *
     * @param Balance $balance
     * @return Response
     */
    public function storeClose(Request $request)
    {
        // Get this cuz I'm not sure if this is a dynamic parameter
        $cashier = Cashier::first();

        $request->merge([
            'date_open' => formatBalanceOpenDate($request),
            'cashier_id' => $cashier->id,
            'value_previous_close' => $request->value_close,
            'close' => $request->value_close,
            'card' => $request->value_card,
            'sales' => $request->value_sales,
        ]);

        $balance = Balance::create($request->all());
        $balance->expenses()->createMany($request->expenses);
        return response()->json([
            'msg' => 'Información guardada con éxito',
            'results' => null,
        ]);
    }
}
