<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CheckoutOrder;

class FactoryPraktikum4No4Test extends TestCase
{
    use RefreshDatabase;

    public function test_factory_5_record():void
    {
    CheckoutOrder::factory()->count(5)->create();
        $this->assertDatabaseCount('checkout_orders', 5);
    }

    Public function test_cek_db_keadaan_aawal():void
    {
        $this->assertDatabaseCount('checkout_orders', 0);
    }
}
