<?php

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

namespace PHPExperts\MoneyType;

use BadMethodCallException;
use InvalidArgumentException;
use PHPExperts\MoneyType\Internal\NumberHelper;

final class NativeCalcStrategy implements MoneyCalculationStrategy
{
    public const I_AM_A_DUMMY = 'But I really need this';

    private $leftOperand;

    /**
     * Converts a float/double to an int with no precision loss.
     *
     * @param string $float
     * @return int
     */
    private function convertToCents($float)
    {
        return (int)round((double) $float * 100);
    }

    public function __construct($leftOperand)
    {
        $this->leftOperand = $this->convertToCents($leftOperand);
    }

    public function getWithFullPrecision(): string
    {
        return (string)($this->leftOperand / 100);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)round($this->leftOperand / 100, 2);
    }


    /**
     * @param string $rightOperand
     * @return string
     */
    public function add($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand += $rightOperand;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function subtract($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand -= $rightOperand;
        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function multiply($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand *= $rightOperand / 100;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function divide($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand /= $rightOperand / 100;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param string|int|float $modulus It must be a float-like
     * @param string $iAmStupid Do you really want an imprecise modulus with a precision package??
     * @return string
     */
    public function modulus($modulus, string $iAmStupid = '')
    {
        if (NumberHelper::isFloatLike($modulus)) {
            throw new InvalidArgumentException('Cannot compute non-integer moduli: Install ext-bcmath.');
        }

        if ($iAmStupid !== self::I_AM_A_DUMMY) {
            throw new BadMethodCallException(
                'You CANNOT get precise a modulus answer via Native PHP. ' . "\n" .
                'Install ext-bcmath (preferred) or set $iAmStupid to true.'
            );
        }

        return (string) (($this->leftOperand / 100) % $modulus);
    }

    /**
     * @param string $rightOperand
     * @return int 0 if equal, -1 if $rightOperand is less, 1 if it is greater.
     */
    public function compare($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);

        return $rightOperand <=> $this->leftOperand;
    }
}
