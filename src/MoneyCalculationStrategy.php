<?php

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2017-2019 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  @ 2017-05-01 14:31 IST
 *  https://www.phpexperts.pro/
 *  https://github.com/phpexpertsinc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType;

interface MoneyCalculationStrategy
{
    public function getWithFullPrecision(): string;
    public function __toString();
    public function add($rightOperand);
    public function subtract($rightOperand);
    public function multiply($rightOperand);
    public function divide($rightOperand);
    public function modulus($modulus);
    public function compare($rightOperand);
}
