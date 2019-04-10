<?php

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2017-2019 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  @ 2017-05-01 14:17 IST
 *  https://www.phpexperts.pro/
 *  https://github.com/phpexpertsinc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType;

class Money implements MoneyCalculationStrategy
{
    protected $strategy;

    /**
     * Money constructor.
     * @param string $amount
     * @param MoneyCalculationStrategy|null $calcStrategy
     */
    public function __construct($amount, MoneyCalculationStrategy $calcStrategy = null)
    {
        if (!$calcStrategy) {
            if (extension_loaded('bcmath')) {
                $calcStrategy = new BCMathCalcStrategy($amount);
            } else {
                $calcStrategy = new NativeCalcStrategy($amount);
            }
        }
        $this->strategy = $calcStrategy;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->strategy->__toString();
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function add($rightOperand)
    {
        return $this->strategy->add($rightOperand);
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function subtract($rightOperand)
    {
        return $this->strategy->subtract($rightOperand);
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function multiply($rightOperand)
    {
        return $this->strategy->multiply($rightOperand);
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function divide($rightOperand)
    {
        return $this->strategy->divide($rightOperand);
    }

    /**
     * @param $modulus
     * @return int
     */
    public function modulus($modulus)
    {
        return $this->strategy->modulus($modulus);
    }

    /**
     * @param float $rightOperand
     * @return int
     */
    public function compare($rightOperand)
    {
        return $this->strategy->compare($rightOperand);
    }
}

/**
 * @param $number
 * @param int $precision
 * @return string
 */
function bcround($number, $precision = 0)
{
    if (strpos($number, '.') !== false) {
        if ($number[0] != '-') return bcadd($number, '0.' . str_repeat('0', $precision) . '5', $precision);
        return bcsub($number, '0.' . str_repeat('0', $precision) . '5', $precision);
    }
    return $number;
}