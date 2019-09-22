<?php

namespace Tests\Unit;

use App\Balance;
use App\Expense;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BalanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_many_expenses()
    {
        $balance = create(Balance::class);
        $expense = create(Expense::class, ['balance_id' => $balance->id]);

        $this->assertEquals(1, $balance->expenses()->count());
        $this->assertEquals($expense->id, $balance->expenses()->first()->id);
    }

    /** @test */
    function it_returns_date_open_with_format()
    {
        $date = '2019/09/12';
        $hour = '12:34:15';
        $this->assertEquals('2019-09-12 12:34:15', formatBalanceOpenDate($date, $hour));
    }


}
