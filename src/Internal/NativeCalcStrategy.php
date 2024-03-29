<?php declare(strict_types=1);

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2017-2023 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  @ 2017-05-01 14:38 IST
 *  https://www.phpexperts.pro/
 *  https://github.com/PHPExpertsInc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType\Internal;

use BadMethodCallException;
use InvalidArgumentException;
use PHPExperts\MoneyType\MoneyCalculationStrategy;

/**
 * @internal
 */
final class NativeCalcStrategy implements MoneyCalculationStrategy
{
    public const I_AM_A_DUMMY = 'But I really need this';

    private $leftOperand;

    public function __construct(string $leftOperand)
    {
        NumberHelper::assertIsNumeric($leftOperand);

        $this->leftOperand = NumberHelper::convertToCents($leftOperand);
    }

    public function getWithFullPrecision(): string
    {
        return (string)($this->leftOperand / 100);
    }

    public function __toString(): string
    {
        return (string)round($this->leftOperand / 100, 2);
    }

    public function add(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $rightOperand = NumberHelper::convertToCents($rightOperand);
        $this->leftOperand += $rightOperand;

        return (string)round($this->leftOperand / 100, 2);
    }

    public function subtract(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $rightOperand = NumberHelper::convertToCents($rightOperand);
        $this->leftOperand -= $rightOperand;
        return (string)round($this->leftOperand / 100, 2);
    }

    public function multiply(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $rightOperand = NumberHelper::convertToCents($rightOperand);
        $this->leftOperand *= $rightOperand / 100;

        return (string)round($this->leftOperand / 100, 2);
    }

    public function divide(string $rightOperand): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $rightOperand = NumberHelper::convertToCents($rightOperand);
        $this->leftOperand /= $rightOperand / 100;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param string $rightOperand It must be a float-like
     * @param string $iAmStupid Do you really want an imprecise modulus with a precision package??
     * @return string
     */
    public function modulus(string $rightOperand, string $iAmStupid = ''): string
    {
        NumberHelper::assertIsNumeric($rightOperand);

        if (NumberHelper::isFloatLike($rightOperand)) {
            throw new InvalidArgumentException('Cannot compute non-integer moduli: Install ext-bcmath.');
        }

        if ($iAmStupid !== self::I_AM_A_DUMMY) {
            throw new BadMethodCallException(
                'You CANNOT get precise a modulus answer via Native PHP. ' . "\n" .
                'Install ext-bcmath (preferred) or set $iAmStupid to true.'
            );
        }

        return (string) (($this->leftOperand / 100) % $rightOperand);
    }

    /**
     * @param string $rightOperand
     * @return int 0 if equal, -1 if $rightOperand is less, 1 if it is greater.
     */
    public function compare(string $rightOperand): int
    {
        NumberHelper::assertIsNumeric($rightOperand);

        $rightOperand = NumberHelper::convertToCents($rightOperand);

        return $rightOperand <=> $this->leftOperand;
    }
}
