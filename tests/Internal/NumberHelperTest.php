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
use PHPExperts\MoneyType\Internal\NumberHelper;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/** @testdox PHPExperts\MoneyType\Internal\NumberHelper: A collection of functions for number manipulation. */
final class NumberHelperTest extends TestCase
{
    public static function assertNotAValidNumber($input)
    {
        try {
            NumberHelper::isFloatLike($input);

            throw new AssertionFailedError('An invalid number was treated like a valid one.');
        } catch (InvalidArgumentException $e) {
            self::assertEquals('This is not a parsable numeric string.', $e->getMessage());
        }
    }

    public function testWillReturnTrueIfGivenAFloat()
    {
        self::assertTrue(NumberHelper::isFloatLike(1.1));
    }

    public function testWillReturnTrueIfGivenAFloatString()
    {
        self::assertTrue(NumberHelper::isFloatLike('1.1'));
    }

    public function testWillReturnFalseIfGivenAnInteger()
    {
        self::assertFalse(NumberHelper::isFloatLike(1));
    }

    public function testWillReturnFalseIfGivenAnIntegerString()
    {
        self::assertFalse(NumberHelper::isFloatLike('1'));
    }

    public function testWillThrowAnExceptionIfGivenAnythingElse()
    {
        // A non-numeric string.
        self::assertNotAValidNumber('asdf');

        // A semi-numeric string.
        self::assertNotAValidNumber('1 asdf');

        // An array
        self::assertNotAValidNumber([]);

        // An object
        self::assertNotAValidNumber(new \stdClass());

        // Boolean
        self::assertNotAValidNumber(true);

        // Null
        self::assertNotAValidNumber(null);

        // Resource
        $fh = fopen('php://memory', 'r');
        self::assertNotAValidNumber($fh);
        fclose($fh);

        // Closure / Callable
        self::assertNotAValidNumber(function () {});
    }

    public function testCanConvertDollarsToCentsIntegerWithoutPrecisionLoss()
    {
        $input    = '122.25';
        $expected = 12225;
        self::assertSame($expected, NumberHelper::convertToCents($input));
    }

    public function testCanConvertBitcoinsToSatoshis()
    {
        $input    = '1.25122345';
        $expected = 125122345;
        self::assertSame($expected, NumberHelper::convertToCents($input, 8));
    }
}
