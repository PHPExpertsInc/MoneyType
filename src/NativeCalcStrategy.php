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

final class NativeCalcStrategy implements MoneyCalculationStrategy
{
    private $leftOperand;

    /**
     * Converts a float/double to an int with no precision loss.
     *
     * @param float $float
     * @return int
     */
    private function convertToCents($float)
    {
        return (int)round($float * 100);
    }

    public function __construct($leftOperand)
    {
        $this->leftOperand = $this->convertToCents($leftOperand);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)round($this->leftOperand / 100, 2);
    }


    /**
     * @param $rightOperand
     * @return string
     */
    public function add($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand += $rightOperand;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function subtract($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand -= $rightOperand;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function multiply($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand *= $rightOperand / 100;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function divide($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand /= $rightOperand / 100;

        return (string)round($this->leftOperand / 100, 2);
    }

    /**
     * @param $modulus
     * @return int
     */
    public function modulus($modulus)
    {
        return ($this->leftOperand / 100) % $modulus;
    }

    /**
     * @param float $rightOperand
     * @return int
     */
    public function compare($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);

        if ($this->leftOperand > $rightOperand) {
            return 1;
        } elseif ($this->leftOperand < $rightOperand) {
            return -1;
        } else {
            return 0;
        }
    }
}
