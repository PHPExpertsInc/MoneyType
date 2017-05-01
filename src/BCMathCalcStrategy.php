<?php
// This file is a part of the MoneyType library, a PHPExperts.pro Project.
//
// Copyright (c) 2017 PHP Experts, Inc. <www.phpexperts.pro>
// Authored by Theodore R. Smith <theodore@phpexperts.pro>
// * 2017-05-01 14:38 IST
//
// This file is licensed under the terms of the MIT license:

namespace PHPExperts\MoneyType;

final class BCMathCalcStrategy implements MoneyCalculationStrategy
{
    private $leftOperand;

    public function __construct($leftOperand)
    {
        $this->leftOperand = $leftOperand;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->leftOperand;
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function add($rightOperand)
    {
        $this->leftOperand = bcadd($this->leftOperand, $rightOperand);

        return $this->leftOperand;
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function subtract($rightOperand)
    {
        $this->leftOperand = bcsub($this->leftOperand, $rightOperand);

        return $this->leftOperand;
    }

    /** string */
    public function multiply($rightOperand)
    {
        $this->leftOperand = bcmul($this->leftOperand, $rightOperand);

        return $this->leftOperand;
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function divide($rightOperand)
    {
        $this->leftOperand = bcdiv($this->leftOperand, $rightOperand);

        return $this->leftOperand;
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
