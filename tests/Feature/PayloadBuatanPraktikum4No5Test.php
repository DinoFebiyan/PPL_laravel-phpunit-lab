<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayloadBuatanPraktikum4No5Test extends TestCase
{
    use RefreshDatabase;
    public function test_Payload_Buatan():void
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
}
