<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CheckoutOrder;

class Harga0Praktikum4No3Test extends TestCase
{
    use RefreshDatabase;
    public function test_harga_nol(): void
    {
        $this->postJson('/api/orders', [
            'harga' => 0, 'jumlah' => 1,
        ])
        ->assertStatus(422)
        ->assertUnprocessable()->assertJsonValidationErrors(['harga']);
 
        $this->assertDatabaseCount('checkout_orders', 0);
    }
}
