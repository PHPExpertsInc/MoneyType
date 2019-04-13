<?php declare(strict_types=1);

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2017-2019 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  @ 2017-05-01 14:38 IST
 *  https://www.phpexperts.pro/
 *  https://github.com/phpexpertsinc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType\Internal;

use InvalidArgumentException;

/**
 * A collection of static functions for number manipulation.
 */
class NumberHelper
{
    /**
     * Asserts if the input is really a numeric string or throws an exception.
     *
     * @param  string $number
     * @throws InvalidArgumentException when the input is not a numeric string.
     */
    public static function assertIsNumeric($number): void
    {
        if (!is_numeric($number)) {
            throw new InvalidArgumentException('This is not a parsable numeric string.');
        }
    }

    /**
     * Determines if a variable appears to be a float or not.
     *
     * @param string|int|double $number
     * @return bool True if it appears to be an integer value. "75.0000" returns false.
     * @throws InvalidArgumentException if $number is not a valid number.
     */
    public static function isFloatLike($number): bool
    {
        // Bail if it isn't even a number.
        self::assertIsNumeric($number);

        // Try to convert the variable to a float.
        $floatVal = floatval($number);

        // If the parsing succeeded and the value is not equivalent to an int, it's probably a float.
        return ($floatVal && intval($floatVal) != $floatVal);
    }

    /**
     * Converts a float-like string to an int with no precision loss.
     *
     * @param  string $float
     * @param  int    $precision
     * @return int
     */
    public static function convertToCents(string $float, int $precision = 2): int
    {
        return (int) round((float)$float * 10**$precision);
    }
}
