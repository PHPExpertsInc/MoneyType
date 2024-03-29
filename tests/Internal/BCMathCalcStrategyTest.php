<?php declare(strict_types=1);

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2019-2023 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  https://www.phpexperts.pro/
 *  https://github.com/PHPExpertsInc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType\Tests\Internal;

use function PHPExperts\MoneyType\Internal\bcround;
use PHPExperts\MoneyType\Internal\BCMathCalcStrategy;
use function PHPExperts\MoneyType\Internal\bcround_v1;
use PHPUnit\Framework\TestCase;

/** @testdox PHPExperts\MoneyType\Internal\BCMathCalcStrategy */
final class BCMathCalcStrategyTest extends TestCase
{
    use MathCalcStrategyTestBase;

    public function setUp(): void
    {
        parent::setUp();

        $this->stratName = BCMathCalcStrategy::class;
        $this->calcStrat = new BCMathCalcStrategy('1.12');
    }

    public function testCanGetTheFullPrecisionValueToMoreThanSixteenDecimals()
    {
        $money = new BCMathCalcStrategy('56.14111331312555551');
        self::assertSame('56.14111331312555551', $money->getWithFullPrecision());
    }

    public function testCanAddWithHighPrecision()
    {
        $this->calcStrat->add('55.021113313');
        self::assertSame('56.1411133131', $this->calcStrat->add('0.0000000001'));
    }

    public function testCanSubtractWithHighPrecision()
    {
        self::assertSame('-53.9011133130', $this->calcStrat->subtract('55.021113313'));
    }

    public function testCanMultiplyWithHighPrecision()
    {
        self::assertSame('61.6236469105', $this->calcStrat->multiply('55.021113313'));
    }

    public function testCanDivideWithHighPrecision()
    {
        self::assertSame('53.0470987665', $this->calcStrat->divide('0.021113313'));
    }

    public function testCanCompareTwoNumbersWithHighPrecision()
    {
        // Assert same with extra precision.
        self::assertSame(0, $this->calcStrat->compare('1.120000000'));

        // Assert is less with extra precision.
        self::assertSame(-1, $this->calcStrat->compare('1.119999999'));

        // Assert is more with extra precision.
        self::assertSame(1, $this->calcStrat->compare('1.120000001'));
    }

    public function testCanComputeHighPrecisionModulus()
    {
        self::assertSame('1.1200000000', $this->calcStrat->modulus('2'));
    }

    public function testCanComputeTheModulusOfDecimals()
    {
        self::assertSame('0.0699993000', $this->calcStrat->modulus('0.1500001'));
    }

    public function testCanRoundWithHighPrecision()
    {
        // Test high precision.
        $expected = '-54.03';
        $actual = bcround('-54.0300000000', 2);
        self::assertSame($expected, $actual);

        // Test no precision.
        $expected = '-54.00';
        $actual = bcround('-54', 2);
        self::assertSame($expected, $actual);
    }

    public function testTheNewRoundingAlgorithmProducesIdenticalResultsToTheOldAlgorithm()
    {
        $expected = '-54.030';
        self::assertEquals($expected, bcround('-54.0300000001', 3));
        self::assertEquals($expected, bcround_v1('-54.0300000001', 3));

        // With padded zeroes.
        $expected = '1231.330';
        self::assertEquals($expected, bcround('1231.33', 3));
        self::assertEquals($expected, bcround_v1('1231.33', 3));

        $expected = '1234.0000';
        self::assertEquals($expected, bcround('1234', 4));
        self::assertEquals($expected, bcround_v1('1234', 4));

    }
}
