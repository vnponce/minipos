<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $dates = [
        'date_open',
    ];

    protected $casts = [
        'value' => 'string', // I'm guessing is equal to value_open property and response must be string here as example says from 'Obtener la información a mostrar en el cierre de caja'
    ];

    protected $fillable = [
        'date_open',
        'value_previous_close',
        'value_open',
        'observation',
        'cashier_id',
        'close',
        'card',
    ];


    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

}
