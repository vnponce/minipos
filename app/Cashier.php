<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    protected $fillable = [
        'date_open',
        'value_previous_cloe',
        'value_open',
        'observation',
    ];
}
