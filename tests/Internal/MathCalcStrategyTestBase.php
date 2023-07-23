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

use InvalidArgumentException;
use PHPExperts\MoneyType\MoneyCalculationStrategy;
use PHPExperts\MoneyType\Tests\MoneyTest;
use ReflectionClass;
use TypeError;

trait MathCalcStrategyTestBase
{
    /** @var MoneyCalculationStrategy */
    protected $calcStrat;

    /** @var string */
    protected $stratName;

    // Inherited from PHPUnit.
    abstract public static function assertInstanceOf(string $expected, $actual, string $message = ''): void;
    abstract public static function assertIsString($actual, string $message = ''): void;
    abstract public static function assertEquals($expected, $actual, string $message = '', float $delta = 0.0, int $maxDepth = 10, bool $canonicalize = false, bool $ignoreCase = false): void;
    abstract public static function assertSame($expected, $actual, string $message = ''): void;

    public function testCanOnlyBeInstantiatedWithANumericString()
    {
        // Numeric String
        $bcMathStrat = new $this->stratName('1.11');
        self::assertInstanceOf($this->stratName, $bcMathStrat);

        $dataTypes = MoneyTest::getNonNumericDataTypes() + [
                'Integer' => 1,
                'Float'   => 1.1,
            ];

        foreach ($dataTypes as $dataTypeDesc => $dataValue) {
            try {
                new $this->stratName($dataValue);
                self::fail("{$this->stratName} was instantiated with a $dataTypeDesc.");
            } catch (TypeError $e) {
                self::assertStringContainsString(
                    '__construct() must be of the type',
                    $e->getMessage(),
                    "Improper instantiation of {$this->stratName} with a {$dataTypeDesc}."
                );
            } catch (InvalidArgumentException $e) {
                self::assertEquals(
                    'This is not a parsable numeric string.',
                    $e->getMessage(),
                    "Improper instantiation of {$this->stratName} with a {$dataTypeDesc}."
                );
            }
        }
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

    public function testWillNotAcceptANonNumberForAnyOperation()
    {
        $calcOps = [
            'add',
            'subtract',
            'multiply',
            'divide',
            'modulus',
            'compare',
        ];

        $stratName = (new ReflectionClass($this->calcStrat))->getShortName();

        foreach ($calcOps as $op) {
            foreach (MoneyTest::getNonNumericDataTypes() as $dataTypeDesc => $dataValue) {
                if (in_array('--debug', $_SERVER['argv'], true)) {
                    echo "Testing {$stratName}::{$op} against {$dataTypeDesc}.\n";
                }

                try {
                    $this->calcStrat->$op($dataValue);
                    self::fail("Oh crap! {$stratName}::{$op} worked with a {$dataTypeDesc}!");
                } catch (InvalidArgumentException $e) {
                    self::assertEquals('This is not a parsable numeric string.', $e->getMessage(), "For {$stratName}::{$op} against {$dataTypeDesc}.");
                } catch (\TypeError $e) {
                    self::assertStringContainsString('must be of the type string', $e->getMessage(), "For {$stratName}::{$op} against {$dataTypeDesc}.");
                }
            }
        }
    }
}
