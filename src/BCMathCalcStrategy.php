<?php
/**
This file is a part of the MoneyType library, a PHPExperts.pro Project.

Copyright (c) 2017 PHP Experts, Inc. <www.phpexperts.pro>
Authored by Theodore R. Smith <theodore@phpexperts.pro>
 * 2017-05-01 14:38 IST

This file is licensed under the terms of the MIT license:
 **/

namespace PHPExperts\MoneyType;

final class BCMathCalcStrategy implements MoneyCalculationStrategy
{
    private $leftOperand;

    public function __construct($leftOperand)
    {
        $this->leftOperand = $leftOperand;
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function add($rightOperand)
    {
        return bcadd($this->leftOperand, $rightOperand);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function subtract($rightOperand)
    {
        return bcsub($this->leftOperand, $rightOperand);
    }

    /** string */
    public function multiply($rightOperand)
    {
        return bcmul($this->leftOperand, $rightOperand);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function divide($rightOperand)
    {
        return bcdiv($this->leftOperand, $rightOperand);
    }

    /**
     * @param string $modulus
     * @return string
     */
    public function modulus($modulus)
    {
        return bcmod($this->leftOperand, $modulus);
    }

    /**
     * @param string $rightOperand
     * @return int
     */
    public function compare($rightOperand)
    {
        return bccomp($this->leftOperand, $rightOperand);
    }
}
