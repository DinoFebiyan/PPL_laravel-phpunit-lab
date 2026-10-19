<?php

namespace Tests\Unit;

use App\Services\DiskonService;
use Tests\TestCase;

class DiskonServiceTest extends TestCase
{
    protected DiskonService $diskonService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->diskonService = new DiskonService();
    }

    public function test_diskon_nol_persen(): void
    {
        $persentase = $this->diskonService->persentase(false, 300000);
        $this->assertEquals(0, $persentase);
    }

    public function test_diskon_member_saja(): void
    {
        $persentase = $this->diskonService->persentase(true, 300000);
        $this->assertEquals(10, $persentase);
    }

    public function test_diskon_subtotal_minimal_500rb(): void
    {
        $persentase = $this->diskonService->persentase(false, 600000);
        $this->assertEquals(5, $persentase);
    }

    public function test_diskon_maksimum_keduanya(): void
    {
        $persentase = $this->diskonService->persentase(true, 600000);
        $this->assertEquals(15, $persentase);
    }
}