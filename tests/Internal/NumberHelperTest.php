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

use InvalidArgumentException;
use PHPExperts\MoneyType\Internal\NumberHelper;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

final class NumberHelperTest extends TestCase
{
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

    public static function assertNotAValidNumber($input)
    {
        try {
            NumberHelper::isFloatLike($input);

            throw new AssertionFailedError('An invalid number was treated like a valid one.');
        } catch (InvalidArgumentException $e) {
            self::assertEquals('This is not a valid number.', $e->getMessage());
        }
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

}
