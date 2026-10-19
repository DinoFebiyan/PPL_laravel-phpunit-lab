<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PraktikumCheckoutHttpTest extends TestCase
{
        use RefreshDatabase;
 
    public function test_kalkulasi_tidak_menyimpan(): void
    {
        $this->postJson('/api/checkout', [
            'harga' => 100000, 'jumlah' => 2,
            'member' => true, 'ekspres' => true,
        ])
        ->assertStatus(200)
        ->assertOk()->assertJsonPath('data.total', 215000);
 
        $this->assertDatabaseCount('checkout_orders', 0);
    }
 
    public function test_api_menyimpan_pesanan(): void
    {
        $this->postJson('/api/orders', [
            'harga' => 300000, 'jumlah' => 2,
            'member' => true, 'ekspres' => false,
        ])
        ->assertStatus(201)
        ->assertCreated()->assertJsonPath('data.total', 510000);

        $this->assertDatabaseCount('checkout_orders', 1);
        $this->assertDatabaseHas('checkout_orders', ['total' => 510000]);
    }
 
    public function test_harga_nol_ditolak(): void
    {
        $this->postJson('/api/orders', [
            'harga' => 0, 'jumlah' => 1,
        ])
        ->assertStatus(422)
        ->assertUnprocessable()->assertJsonValidationErrors(['harga']);
 
        $this->assertDatabaseCount('checkout_orders', 0);
    }

    public function test_order_tidak_ditemukan(): void
    {
        $this->getJson('/api/orders/999999')
            ->assertStatus(404)
            ->assertNotFound();

        $this->assertDatabaseCount('checkout_orders', 0);
    }
}
