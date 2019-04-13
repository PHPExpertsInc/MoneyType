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

namespace PHPExperts\MoneyType\Tests\Internal;

use PHPExperts\MoneyType\Internal\MoneyCalculationStrategy;

trait MathCalcStrategyTestBase
{
    /** @var MoneyCalculationStrategy */
    protected $calcStrat;

    /** @var string */
    protected $calcStratName;

    // Inherited from PHPUnit.
    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;
    abstract public static function assertIsString($actual, string $message = ''): void;
    abstract public static function assertEquals($expected, $actual, string $message = '', float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false, bool $ignoreCase = false): void;
    abstract public static function assertSame($expected, $actual, string $message = ''): void;

    public function testCanBeInstantiatedWithAnInteger()
    {
        $bcMathStrat = new $this->calcStratName(1);
        self::assertInstanceOf($this->calcStratName, $bcMathStrat);
    }

    public function testCanBeInstantiatedWithAFloat()
    {
        $bcMathStrat = new $this->calcStratName(1.0);
        self::assertInstanceOf($this->calcStratName, $bcMathStrat);
    }

    public function testCanBeInstantiatedWithAString()
    {
        $bcMathStrat = new $this->calcStratName('1.11');
        self::assertInstanceOf($this->calcStratName, $bcMathStrat);
    }

    public function testAccessTheObjectAsAStringToGetItsValuation()
    {
        $actual = '+' . $this->calcStrat . '+';
        self::assertIsString($actual);

        $expected = '+1.12+';
        self::assertEquals($expected, $actual);
        self::assertSame($expected, $actual);
    }

    public function testCanAddWithCentPrecision()
    {
        $output = $this->calcStrat->add('55.15');
        self::assertSame('56.27', $this->calcStrat.'', "The literal output: $output");
    }

    public function testCanSubtractWithCentPrecision()
    {
        $output = $this->calcStrat->subtract('55.15');

        self::assertSame('-54.03', $this->calcStrat.'', "The literal output: $output");
    }

    public function testCanMultiplyWithCentPrecision()
    {
        // Actual answer: 61.768
        $output = $this->calcStrat->multiply('55.15');
        self::assertSame('61.77', $this->calcStrat.'', "The literal output: $output");
    }

    public function testCanDivideWithCentPrecision()
    {
        $output = $this->calcStrat->divide('0.06');
        self::assertEquals('18.67', $this->calcStrat.'', "The literal output: $output");
    }

    public function testCanCompareTwoNumbersWithCentPrecision()
    {
        // Assert same.
        self::assertSame(0, $this->calcStrat->compare('1.12'));

        // Assert is less.
        self::assertSame(-1, $this->calcStrat->compare('1.11'));

        // Assert is more.
        self::assertSame(1, $this->calcStrat->compare('1.13'));
    }
}
