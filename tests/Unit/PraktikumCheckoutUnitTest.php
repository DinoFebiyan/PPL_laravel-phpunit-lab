<?php

namespace Tests\Unit;

use App\Services\CheckoutService;
use App\Services\DiskonService;
use App\Services\OngkirService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PraktikumCheckoutUnitTest extends TestCase
{
    public function test_kalkulasi_checkout_berhasil(): void
    {
        $service = new CheckoutService(new DiskonService(), new OngkirService());
        $hasil = $service->hitung(100000, 2, true, true);
        self::assertSame(200000, $hasil['subtotal']);
        self::assertSame(20000, $hasil['potongan_diskon']);
        self::assertSame(35000, $hasil['ongkir']);
        self::assertSame(215000, $hasil['total']);
    }

    public function test_exception_harga_nol(): void
    {
        $service = new CheckoutService(new DiskonService(), new OngkirService());
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Harga harus lebih dari nol.');
        $service->hitung(0, 1, false, false);
    }

    public function test_exception_jumlah_nol(): void
    {
        $service = new CheckoutService(new DiskonService(), new OngkirService());
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Jumlah harus lebih dari nol.');
        $service->hitung(100000, 0, false, false);
    }

    public function test_checkout_dengan_mock_service(): void
    {
        $diskon = $this->createMock(DiskonService::class);
        $ongkir = $this->createMock(OngkirService::class);

        $diskon->expects($this->once())
            ->method('persentase')
            ->with(true, 600000)
            ->willReturn(10);

        $ongkir->expects($this->once())
            ->method('hitung')
            ->with(540000, false)
            ->willReturn(0);

        $hasil = (new CheckoutService($diskon, $ongkir))
            ->hitung(300000, 2, true, false);

        self::assertSame(540000, $hasil['total']);
    }

    public function test_kalkulasi_valid_dengan_service_asli(): void
    {
        $service = new CheckoutService(new DiskonService(), new OngkirService());
        
        $hasil = $service->hitung(300000, 2, true, false);

        self::assertSame(600000, $hasil['subtotal']);
        self::assertSame(15, $hasil['persentase_diskon']);
        self::assertSame(510000, $hasil['total']);
    }

    public function test_withtrue_500(): void
    {
        $diskon = $this->createMock(DiskonService::class);
        $ongkir = $this->createMock(OngkirService::class);

        $diskon->expects($this->once())
            ->method('persentase')
            ->with(true, 500000)
            ->willReturn(10);

        $ongkir->expects($this->once())
            ->method('hitung')
            ->with(540000, false)
            ->willReturn(0);

        $hasil = (new CheckoutService($diskon, $ongkir))
            ->hitung(300000, 2, true, false);

        self::assertSame(540000, $hasil['total']);
    }
}