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

use PHPExperts\MoneyType\Internal\BCMathCalcStrategy;
use PHPExperts\MoneyType\Internal\NativeCalcStrategy;
use ReflectionClass;
use ReflectionException;

final class Money implements MoneyCalculationStrategy
{
    protected $strategy;

    /**
     * Money constructor.
     * @param string $amount
     * @param MoneyCalculationStrategy|null $calcStrategy
     */
    /**
     * Money constructor.
     * @param string $amount
     * @param MoneyCalculationStrategy|null $calcStrategy
     * @param callable|null $hasBCMath
     */
    public function __construct($amount, MoneyCalculationStrategy $calcStrategy = null, callable $hasBCMath = null)
    {
        if (!$hasBCMath) {
            $hasBCMath = function(): bool {
                return extension_loaded('bcmath');
            };
        }

        if (!$calcStrategy) {
            if ($hasBCMath()) {
                $calcStrategy = new BCMathCalcStrategy($amount);
            } else {
                $calcStrategy = new NativeCalcStrategy($amount);
            }
        }
        $this->strategy = $calcStrategy;
    }

    public function getWithFullPrecision(): string
    {
        return $this->strategy->getWithFullPrecision();
    }

    /**
     * Outputs the dollars and cents of the object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->strategy->__toString();
    }

    /**
     * Returns the strategy used.
     *
     * @return string
     * @throws ReflectionException
     */
    public function getStrategy(): string
    {
        return (new ReflectionClass($this->strategy))->getShortName();
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function add($rightOperand)
    {
        return $this->strategy->add($rightOperand);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function subtract($rightOperand)
    {
        return $this->strategy->subtract($rightOperand);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function multiply($rightOperand)
    {
        return $this->strategy->multiply($rightOperand);
    }

    /**
     * @param string $rightOperand
     * @return string
     */
    public function divide($rightOperand)
    {
        return $this->strategy->divide($rightOperand);
    }

    /**
     * @param string $modulus
     * @return int
     */
    public function modulus($modulus)
    {
        return $this->strategy->modulus($modulus);
    }

    /**
     * @param string $rightOperand
     * @return int
     */
    public function compare($rightOperand)
    {
        return $this->strategy->compare($rightOperand);
    }
}
