<?php
/**
This file is a part of the MoneyType library, a PHPExperts.pro Project.

Copyright (c) 2017 PHP Experts, Inc. <www.phpexperts.pro>
Authored by Theodore R. Smith <theodore@phpexperts.pro>
 * 2017-05-01 14:31 IST

This file is licensed under the terms of the MIT license:
 **/

namespace PHPExperts\MoneyType;

interface MoneyCalculationStrategy
{
    public function add($rightOperand);
    public function subtract($rightOperand);
    public function multiply($rightOperand);
    public function divide($rightOperand);
    public function modulus($modulus);
    public function compare($rightOperand);
}
