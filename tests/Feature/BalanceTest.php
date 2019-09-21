<?php

namespace Tests\Feature;

use App\{ User, Cashier, Balance };
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BalanceTest extends TestCase
{
    // use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        create(Cashier::class);

        $user = new User;
        $this->actingAs($user, 'api');
    }

    /** @test */
    public function get_cashier_balance()
    {
        $cashier = Cashier::first();
        // dd($cashier->id);
        $date = Carbon::create(2019, 06, 11, 12, 45);
        // dd($date->format('Y/m/d H:i'));
        create(Balance::class, [
            'date_open' => $date->timestamp,
            'value_previous_close' => 6248,
            'value_open' => null,
            'observation' => '',
            'cashier_id' => $cashier->id,
        ]);
        $response = $this->get('/api/v1/cashier/balance');

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

    /** @test */
    function it_can_store_cashier_balance_open_day()
    {
        $response = $this->post("/api/v1/cashier/balance/open/day", [
            "date_open" => "2019/06/11",
            "hour_open" => "12:45:00",
            "value_previous_close" => 6280,
            "value_open" => 100,
            "observation" => ""
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "msg" =>"Información guardada con éxito",
            "results" => [
                "date_open" => "2019/06/11",
    	        "hour_open" => "12:45:00",
       	        "value_previous_close" => 6280,
    	        "value_open" => 100,
    	        "observation" => ""
	        ],
        ]);

        $this->assertDatabaseHas('balances', [
            "date_open" => "2019-06-11 12:45:00",
    	    "value_previous_close" => 6280,
	        "value_open" => 100,
        	"observation" => null
        ]);
    }
}
