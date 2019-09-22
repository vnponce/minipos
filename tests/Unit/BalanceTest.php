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


}
