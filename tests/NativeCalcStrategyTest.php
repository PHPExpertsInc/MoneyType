<?php

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

use InvalidArgumentException;
use PHPExperts\MoneyType\NativeCalcStrategy;
use PHPUnit\Framework\TestCase;

class NativeCalcStrategyTest extends TestCase
{
    use MathCalcStrategyTestBase;

    /** @var NativeCalcStrategy */
    protected $calcStrat;

    public function setUp()
    {
        parent::setUp();

        $this->calcStratName = NativeCalcStrategy::class;
        $this->calcStrat = new NativeCalcStrategy('1.12');
    }

    public function testWontAttemptOperationsWithNonNumbers()
    {
        // @FIXME: This functionality needs to be expanded to EVERY operation -and- strategy.
        try {
            $this->calcStrat->modulus('Not A Number');
            $this->fail('It somehow tried to compute a non-number modulus.');
        }
        catch (InvalidArgumentException $e) {
            $this->assertEquals("This is not a valid number.", $e->getMessage());
        }
    }

    public function testCanGetTheFullPrecisionValueToTwoDecimals()
    {
        $money = new NativeCalcStrategy('56.14111331312555551');
        self::assertSame('56.14', $money->getWithFullPrecision());
    }

    public function testCannotComputeTheModulusOfDecimals()
    {
        try {
            $this->calcStrat->modulus('0.1500001');
            $this->fail('It somehow tried to compute a decimal modulus.');
        }
        catch (InvalidArgumentException $e) {
            self::assertEquals('Cannot compute non-integer moduli: Install ext-bcmath.', $e->getMessage());
        }
    }

    public function testWillThrowAnExceptionIfAskedToComputeAnIntegerModulus()
    {
        $this->expectException('BadMethodCallException');
        $this->calcStrat->modulus('2');
    }

    public function testCanComputeTheModulusOfIntegersIfDevPassesIAmADummyParameter()
    {
        self::assertSame('1', $this->calcStrat->modulus('2', NativeCalcStrategy::I_AM_A_DUMMY));
    }
}
