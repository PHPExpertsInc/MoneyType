<?php
/**
This file is a part of the MoneyType library, a PHPExperts.pro Project.

Copyright (c) 2017 PHP Experts, Inc. <www.phpexperts.pro>
Authored by Theodore R. Smith <theodore@phpexperts.pro>
 * 2017-05-01 14:38 IST

This file is licensed under the terms of the MIT license:
 **/

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
     * @param $rightOperand
     * @return float
     */
    public function add($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand += $rightOperand;

        return (double)($this->leftOperand / 100);
    }

    /**
     * @param $rightOperand
     * @return float
     */
    public function subtract($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand -= $rightOperand;

        return (double)($this->leftOperand / 100);
    }

    /**
     * @param $rightOperand
     * @return float
     */
    public function multiply($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand *= $rightOperand;

        return (double)($this->leftOperand / 100);
    }

    public function divide($rightOperand)
    {
        $rightOperand = $this->convertToCents($rightOperand);
        $this->leftOperand /= $rightOperand;

        return (double)($this->leftOperand / 100);
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
