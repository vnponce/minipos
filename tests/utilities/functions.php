<?php
function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

function formatBalanceOpenDate($date, $hour)
{
    return str_replace('/', '-', $date .' '. $hour);
}
