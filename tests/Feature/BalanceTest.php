<?php

namespace Tests\Feature;

use App\{ User, Cashier, Balance };
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BalanceTest extends TestCase
{
    use RefreshDatabase;

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
        $date = Carbon::create(2019, 06, 11, 12, 45);
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
                'hour_open' => '12:45:00',
                'value_previous_close' => 6248,
                'value_open' => null,
                'observation' => ''
            ]
        ]);
    }

    /** @test */
    function it_can_store_cashier_balance_open_day()
    {
        $response = $this->post('/api/v1/cashier/balance/open/day', [
            'date_open' => '2019/06/11',
            'hour_open' => '12:45:00',
            'value_previous_close' => 6280,
            'value_open' => 100,
            'observation' => ''
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'msg' =>'Información guardada con éxito',
            'results' => [
                'date_open' => '2019/06/11',
    	        'hour_open' => '12:45:00',
       	        'value_previous_close' => 6280,
    	        'value_open' => 100,
    	        'observation' => ''
	        ],
        ]);

        $this->assertDatabaseHas('balances', [
            'date_open' => '2019-06-11 12:45:00',
    	    'value_previous_close' => 6280,
	        'value_open' => 100,
        	'observation' => null
        ]);
    }
    /** @test */
    public function get_has_open_cashier_balance()
    {
        $cashier = Cashier::first();
        $date = Carbon::create(2019, 06, 11, 12, 45);
        create(Balance::class, [
            'date_open' => $date->timestamp,
            'value_previous_close' => 6248,
            'value_open' => 5000,
            'observation' => '',
            'cashier_id' => $cashier->id,
            'close' => 0,
            'card' => 0,
        ]);
        $response = $this->get('/api/v1/has/open/cashier/balance');

        $response->assertStatus(200);
        $response->assertJson([
            'msg' => 'Success',
            'results' => true,
            'value' => 5000,
            'close' => '0',
            'card' => '0',
        ]);
    }

    /** @test */
    public function it_returns_does_not_show_data_when_value_open_is_null()
    {
        $cashier = Cashier::first();
        $date = Carbon::create(2019, 06, 11, 12, 45);
        create(Balance::class, [
            'date_open' => $date->timestamp,
            'value_previous_close' => 6248,
            'value_open' => null,
            'observation' => '',
            'cashier_id' => $cashier->id,
            'close' => 0,
            'card' => 0,
        ]);
        $response = $this->get('/api/v1/has/open/cashier/balance');

        $response->assertStatus(200);
        $response->assertJson([
            'msg' => 'No se puede mostrar esta información',
        ]);
    }

    /** @test */
    public function it_can_store_cashier_balance_close_day()
    {
        $response = $this->post('/api/v1/cashier/balance/close/day', [
            'date_open' => '2019/06/11',
            'hour_open' => '13:45:15',
            'value_card' => 0,
            'value_cash' => 0,
            'value_close' => 5000,
            'value_open' => 5000,
            'value_sales' => 0,
            'expenses' => [
                [
                    'name' => 'aaa',
                    'value' => 1000,
                ],
                [
                    'name' => 'bbb',
                    'value' => 567,
                ],
            ]
        ]);

        // dd($response);

        $response->assertStatus(200);
        $response->assertJson([
            'msg' =>'Información guardada con éxito',
            'results' => null,
        ]);

        $balance = Balance::first();
        $this->assertDatabaseHas('expenses', [
            'balance_id' => $balance->id,
            'name' => 'aaa',
            'value' => 1000,
        ]);
        $this->assertDatabaseHas('expenses', [
            'balance_id' => $balance->id,
            'name' => 'bbb',
            'value' => 567,
        ]);
        $this->assertDatabaseHas('balances', [
            'date_open' => '2019-06-11 13:45:15',
            'value_previous_close' => 5000,
            'value_open' => 5000,
            'card' => 0,
            'cash' => 0,
            'sales' => 0,
        ]);
    }

}
