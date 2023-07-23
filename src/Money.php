<?php declare(strict_types=1);

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2017-2023 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  @ 2017-05-01 14:17 IST
 *  https://www.phpexperts.pro/
 *  https://github.com/PHPExpertsInc/MoneyType
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

    public function __construct(string $amount, MoneyCalculationStrategy $calcStrategy = null, callable $hasBCMath = null)
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
    public function __toString(): string
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

    public function add($rightOperand): string
    {
        return $this->strategy->add($rightOperand);
    }

    public function subtract($rightOperand): string
    {
        return $this->strategy->subtract($rightOperand);
    }

    public function multiply($rightOperand): string
    {
        return $this->strategy->multiply($rightOperand);
    }

    public function divide($rightOperand): string
    {
        return $this->strategy->divide($rightOperand);
    }

    public function modulus($rightOperand): string
    {
        return $this->strategy->modulus($rightOperand);
    }

    public function compare($rightOperand): int
    {
        return $this->strategy->compare($rightOperand);
    }
}
