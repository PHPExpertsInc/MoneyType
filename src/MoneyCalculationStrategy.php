<?php declare(strict_types=1);

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2017-2023 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  @ 2017-05-01 14:31 IST
 *  https://www.phpexperts.pro/
 *  https://github.com/PHPExpertsInc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType;

interface MoneyCalculationStrategy
{
    public function __construct(string $leftOperand);
    public function __toString(): string;
    public function getWithFullPrecision(): string;
    public function add(string $rightOperand): string;
    public function subtract(string $rightOperand): string;
    public function multiply(string $rightOperand): string;
    public function divide(string $rightOperand): string;
    public function modulus(string $rightOperand): string;
    public function compare(string $rightOperand): int;
}
