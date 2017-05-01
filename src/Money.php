<?php
// This file is a part of the MoneyType library, a PHPExperts.pro Project.
//
// Copyright (c) 2017 PHP Experts, Inc. <www.phpexperts.pro>
// Authored by Theodore R. Smith <theodore@phpexperts.pro>
//  * 2017-05-01 14:17 IST
//
// This file is licensed under the terms of the MIT license:

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
        return (string)$this->strategy;
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
