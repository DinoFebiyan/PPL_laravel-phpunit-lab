<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CheckoutOrder;

class CheckoutOrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_dbCount_dan_dbHas(): void
    {
        $this->postJson('/api/orders', [
            'harga' => 300000, 'jumlah' => 2,
            'member' => true, 'ekspres' => false,
        ])
        ->assertStatus(201)
        ->assertCreated()->assertJsonPath('data.total', 510000);

        $this->assertDatabaseCount('checkout_orders', 1);
        $this->assertDatabaseHas('checkout_orders', [
            'subtotal' => 600000,
            'potongan_diskon' => 90000,
            'total' => 510000,
        ]);
    }

    public function test_data_diskon_dari_klien():void
    {
    $this->postJson('/api/orders', [
        'harga' => 300000, 'jumlah' => 2,
        'member' => true, 'ekspres' => false,
        'total' => 1, 'persentase_diskon' => 100,
    ])->assertCreated()->assertJsonPath('data.total', 510000);
    
    $this->assertDatabaseHas('checkout_orders', [
        'total' => 510000,
        'persentase_diskon' => 15,
    ]);
    }

    public function test_factory():void
    {
    CheckoutOrder::factory()->count(3)->create();
        $this->assertDatabaseCount('checkout_orders', 3);
    }

    public function test_seeder():void
    {
    $this->seed();
    $this->assertDatabaseCount('checkout_orders', 12);
    }

    public function test_factory_dan_seeder():void
    {
    CheckoutOrder::factory()->count(3)->create();
        $this->assertDatabaseCount('checkout_orders', 3);
    $this->seed();
    $this->assertDatabaseCount('checkout_orders', 15);
    }
}
