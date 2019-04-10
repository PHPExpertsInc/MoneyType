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

final class BCMathCalcStrategy implements MoneyCalculationStrategy
{
    public const PRECISION = 10;

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
        return bcround($this->leftOperand, 2);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function add($rightOperand)
    {
        $this->leftOperand = bcadd($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function subtract($rightOperand)
    {
        $this->leftOperand = bcsub($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    /**
     * @param $rightOperand
     * @return string
     */
    public function multiply($rightOperand)
    {
        $this->leftOperand = bcmul($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function divide($rightOperand)
    {
        $this->leftOperand = bcdiv($this->leftOperand, $rightOperand, self::PRECISION);

        return $this->leftOperand;
    }

    /**
     * @param $modulus
     * @return string
     */
    public function modulus($modulus)
    {
        return bcmod($this->leftOperand, $modulus, self::PRECISION);
    }

    /**
     * @param string $rightOperand
     * @return int 0 if equal, -1 if $rightOperand is less, 1 if it is greater.
     */
    public function compare($rightOperand)
    {
        return bccomp($rightOperand, $this->leftOperand, self::PRECISION);
    }
}
