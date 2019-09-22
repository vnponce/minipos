<?php
function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

function formatBalanceOpenDate($data)
{
    return str_replace('/', '-', $data->date_open .' '. $data->hour_open);
}
