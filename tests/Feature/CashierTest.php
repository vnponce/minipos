<?php

namespace Tests\Feature;

use App\Cashier;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashierTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = new User;
        $this->actingAs($user, 'api');
    }

    /** @test */
    public function get_cashier_balance()
    {
//        $cashier = create(Cashier::class);
        $date = Carbon::create(2019, 06, 11, 12, 45);
        factory(Cashier::class)->create([
            'date_open' => $date,
            'value_previous_close' => 6248,
            'value_open' => null,
            'observation' => ''
        ]);
        $response = $this->get('/api/v1/balance');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'Success',
            'results' => [
                'date_open' => '2019/06/11',
                'hour_open' => '12:45',
                'value_previous_close' => 6248,
                'value_open' => null,
                'observation' => ''
            ]
        ]);
    }
}
