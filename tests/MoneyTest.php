<?php declare(strict_types=1);

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2019 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  https://www.phpexperts.pro/
 *  https://github.com/phpexpertsinc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType\Tests;

use PHPExperts\MoneyType\Internal\NumberHelper;
use PHPExperts\MoneyType\Money;
use PHPExperts\MoneyType\MoneyCalculationStrategy;
use PHPUnit\Framework\TestCase;

/** @testdox PHPExperts\MoneyType\Money */
final class MoneyTest extends TestCase
{
    private static function assertCalcStrategy(Money $moneyType, string $expected)
    {
        $actual = $moneyType->getStrategy();

        self::assertSame($expected, $actual);
    }

    public static function getNonNumericDataTypes(): array
    {
        return [
            'Non-numerical string' => 'asdf',
            'Semi-numeric string'  => '1 asdf',
            'Array'                => [],
            'Object'               => new \stdClass(),
            'Boolean'              => true,
            'Null'                 => null,
            'Resource'             => fopen('php://memory', 'r'),
            'Closure / Callable'   => function() {},
        ];
    }

    public static function buildMockCalcStrategy(): MoneyCalculationStrategy
    {
        return new class('asdf') implements MoneyCalculationStrategy
        {
            public function __toString(): string
            {
                return '0';
            }

            public function getWithFullPrecision(): string
            {
                return '1';
            }

            public function add(string $rightOperand): string
            {
                return '2';
            }

            public function subtract(string $rightOperand): string
            {
                return '3';
            }

            public function multiply(string $rightOperand): string
            {
                return '4';
            }

            public function divide(string $rightOperand): string
            {
                return '5';
            }

            public function modulus(string $rightOperand): string
            {
                return '6';
            }

            public function compare(string $rightOperand): int
            {
                return 7;
            }

            public function __construct(string $leftOperand)
            {
            }
        };
    }

    public function testCanOnlyBeInstantiatedWithANumericString()
    {
        self::assertInstanceOf(Money::class, new Money('5', self::buildMockCalcStrategy()));
    }

    public function testWillReportWhatStrategyIsBeingUsed()
    {
        $moneyType = new Money('5');
        self::assertCalcStrategy($moneyType, 'BCMathCalcStrategy');
    }

    /** @testdox Will use BCMath if it is available */
    public function testWillUseBCMathIfItIsAvailable()
    {
        $hasBCMath = function(): bool {
            return true;
        };

        $moneyType = new Money('5', null, $hasBCMath);
        self::assertCalcStrategy($moneyType, 'BCMathCalcStrategy');
    }

    public function testWillFallBackToNativePhpIfNecessary()
    {
        $hasBCMath = function() {
            return false;
        };

        $moneyType = new Money('5', null, $hasBCMath);
        self::assertCalcStrategy($moneyType, 'NativeCalcStrategy');
    }

    public function testProxiesEverythingToItsCalculationStrategy()
    {
        $mockCalcStrat = self::buildMockCalcStrategy();
        $moneyType = new Money('5', $mockCalcStrat);

        $calcStratOps = get_class_methods($mockCalcStrat);
        // Filter out the __construct method.
        $calcStratOps = array_diff($calcStratOps, ['__construct']);

        foreach ($calcStratOps as $index => $op) {
            self::assertEquals($index, $moneyType->$op('0'), $op);
        }
    }

    public function testConfirmThatTheReadmeDemoWorks()
    {
        $money = new Money('5.22');

        $money->add('0.55');
        self::assertSame('5.77', $money.'');

        # It keeps precision much much better than mere cents.
        $money->subtract('0.0001');
        self::assertSame('5.77', $money.'');

        $money->subtract('0.004');
        self::assertSame('5.77', $money.'');

        $money->subtract('0.001');
        self::assertSame('5.76', $money.'');

        $money->multiply('55.777355');
        self::assertSame('321.55', $money.'');
        self::assertSame('321.5508738395', $money->getWithFullPrecision());

        $money->divide('1.000005');
        self::assertSame('321.55', $money.'');
        self::assertSame('321.5492660931', $money->getWithFullPrecision());

        self::assertSame(0,  $money->compare('321.5492660931')); //  0 = equal
        self::assertSame(-1, $money->compare('321.5492660930')); // -1 = less
        self::assertSame(1,  $money->compare('321.5492660932')); //  1 = more

        $btc = '1.55527331';
        $sats = 155527331;
        self::assertSame($sats, NumberHelper::convertToCents($btc, 8));
    }
}

