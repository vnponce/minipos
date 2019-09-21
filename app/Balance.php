<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $dates = [
        'date_open',
    ];

    protected $dateFormat = 'Y/m/d H:i';

    protected $fillable = [
        'date_open',
        'value_previous_close',
        'value_open',
        'observation',
        'cashier_id',
    ];

}