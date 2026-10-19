<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_schema_tabel_checkout_orders(): void
    {
        $this->assertTrue(
            Schema::hasTable('checkout_orders'), 
            'Tabel checkout_orders tidak ditemukan di database.'
        );

        $kolomWajib = [
            'id',
            'harga',
            'jumlah',
            'subtotal',
            'persentase_diskon',
            'potongan_diskon',
            'ongkir',
            'total',
            'created_at',
            'updated_at',
        ];

        foreach ($kolomWajib as $kolom) {
            $this->assertTrue(
                Schema::hasColumn('checkout_orders', $kolom), 
                "Kolom '{$kolom}' tidak ditemukan di dalam tabel checkout_orders."
            );
        }
    }
}