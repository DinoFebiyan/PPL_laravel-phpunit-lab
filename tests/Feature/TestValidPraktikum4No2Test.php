<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CheckoutOrder;

class TestValidPraktikum4No2Test extends TestCase
{
    use RefreshDatabase;

    public function test_tes_valid(): void
    {
        $this->postJson('/api/orders', [
            'harga' => 300000, 'jumlah' => 2,
            'member' => true, 'ekspres' => false,
        ])
        ->assertStatus(201)
        ->assertCreated();

        $this->assertDatabaseCount('checkout_orders', 1);
        $this->assertDatabaseHas('checkout_orders', [
            'subtotal' => 600000,
            'potongan_diskon' => 90000,
            'total' => 510000,
        ]);
    }
}
