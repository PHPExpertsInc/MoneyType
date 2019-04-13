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

use PHPExperts\MoneyType\MoneyCalculationStrategy;

/**
 * @internal
 */
final class BCMathCalcStrategy implements MoneyCalculationStrategy
{
    public const PRECISION = 10;

    private $leftOperand;

    public function __construct(string $leftOperand)
    {
        NumberHelper::assertIsNumeric($leftOperand);

        $this->leftOperand = $leftOperand;
    }

    public function getWithFullPrecision(): string
    {
        return $this->leftOperand;
    }

    public function __toString(): string
    {
        return bcround($this->leftOperand, 2);
    }

    public function add(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $this->leftOperand = bcadd($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    public function subtract(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $this->leftOperand = bcsub($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    public function multiply(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $this->leftOperand = bcmul($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    public function divide(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $this->leftOperand = bcdiv($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    public function modulus(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        return bcmod($this->leftOperand, $rightOperand, self::PRECISION);
    }

    /**
     * @param string $rightOperand
     * @return int 0 if equal, -1 if $rightOperand is less, 1 if it is greater.
     */
    public function compare(string $rightOperand): int
    {
        NumberHelper::assertIsNumeric($rightOperand);

        return bccomp($rightOperand, $this->leftOperand, self::PRECISION);
    }
}

/**
 * Based off of https://stackoverflow.com/a/1653826/430062
 * Thanks, [Alix Axel](https://stackoverflow.com/users/89771/alix-axel)!
 *
 * @param string $number
 * @param int $precision
 * @return string
 */
function bcround(string $number, int $precision = BCMathCalcStrategy::PRECISION): string
{
    NumberHelper::assertIsNumeric($number);

    if (strpos($number, '.') !== false) {
        if ($number[0] != '-') return bcadd($number, '0.' . str_repeat('0', $precision) . '5', $precision);
        return bcsub($number, '0.' . str_repeat('0', $precision) . '5', $precision);
    }

    // Pad it out to the desired precision.
    return number_format((double) $number, $precision);
}
