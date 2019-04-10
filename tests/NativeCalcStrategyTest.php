<?php

/**
 * This file is part of MoneyType, a PHP Experts, Inc., Project.
 *
 * Copyright © 2019 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  https://www.phpexperts.pro/
 *  https://github.com/phpexpertsinc/MoneyType
 *
 * This file is licensed under the MIT License.
 */

namespace PHPExperts\MoneyType\Tests;

use InvalidArgumentException;
use PHPExperts\MoneyType\NativeCalcStrategy;
use PHPUnit\Framework\TestCase;

class NativeCalcStrategyTest extends TestCase
{
    use MathCalcStrategyTestBase;

    /** @var NativeCalcStrategy */
    protected $calcStrat;

    public function setUp()
    {
        parent::setUp();

        $this->calcStratName = NativeCalcStrategy::class;
        $this->calcStrat = new NativeCalcStrategy('1.12');
    }
}
