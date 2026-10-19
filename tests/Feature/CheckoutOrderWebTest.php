<?php

namespace Tests\Feature;

use App\Models\CheckoutOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutOrderWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_utama_bisa_diakses(): void
    {
        $this->get(route('checkout.index'))
            ->assertOk();
    }

    public function test_web_menyimpan_pesanan_dan_redirect(): void
    {
        $this->post(route('orders.store'), [
            'harga' => 300000,
            'jumlah' => 2,
            'member' => true,
            'ekspres' => false,
        ])
        ->assertStatus(302)
        ->assertRedirect(route('orders.index'))
        ->assertSessionHas('success');

        $this->assertDatabaseCount('checkout_orders', 1);$this->assertDatabaseHas('checkout_orders', ['total' => 510000]);
    }

    public function test_halaman_orders_bisa_diakses(): void
    {
        CheckoutOrder::factory()->count(2)->create();

        $this->get(route('orders.index'))
            ->assertOk();
    }
}