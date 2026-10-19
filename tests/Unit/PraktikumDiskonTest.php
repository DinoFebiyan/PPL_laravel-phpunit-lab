<?php
namespace Tests\Unit;
 
use App\Services\DiskonService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
 
class PraktikumDiskonTest extends TestCase
{
    public static function dataDiskon(): array
    {
        return [
            'P1' => [false, 100000, 0],
            'P2' => [true, 100000, 10],
            'P3' => [false, 600000, 5],
            'P4' => [true, 600000, 15],
            'B1' => [false, 499000, 0],
            'B2' => [false, 500000, 5],
        ];
    }
 
    #[DataProvider('dataDiskon')]
    public function test_persentase_diskon(
        bool $member, int $subtotal, int $expected
    ): void {
        $hasil = (new DiskonService())->persentase($member, $subtotal);
        self::assertSame($expected, $hasil);
    }
}
