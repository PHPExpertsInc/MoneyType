# Money Type

[![TravisCI](https://travis-ci.org/phpexpertsinc/MoneyType.svg?branch=master)](https://travis-ci.org/phpexpertsinc/MoneyType)
[![Maintainability](https://api.codeclimate.com/v1/badges/37f9c3f6a89b5a72256e/maintainability)](https://codeclimate.com/github/phpexpertsinc/MoneyType/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/37f9c3f6a89b5a72256e/test_coverage)](https://codeclimate.com/github/phpexpertsinc/MoneyType/test_coverage)

MoneyType is a PHP Experts, Inc., Project meant to keep track of money precisely, even up to millions of dollars.

It is never safe to store money as floats or even integers times one hundred. This project gives you the security
you need, so that something like the bug in ["Office Space"](https://www.imdb.com/title/tt0151804/) just won't
happen to your enterprise application.

## Installation

Via Composer

```bash
composer require phpexperts/money
```

## Usage

```php
use PHPExperts\MoneyType\Money;

$money = new Money(5.22);

$money->add(0.55);
echo "$money\n"; // 5.77

# It keeps precision much much better than mere cents.
$money->subtract(0.0001);
echo "$money\n"; // 5.77
$money->subtract(0.004);
echo "$money\n"; // 5.77
$money->subtract(0.001);
echo "$money\n"; // 5.76

# Actually, to the tenth decimal place.
# So it's Cryptocurrency-ready!
$money->multiply(55.7773);
echo "$money\n"; // 321.55

# But deep down, it stores the true values to many decimals (if you use BCMath).
echo $money->getWithFullPrecision() . "\n"; // 321.5508738395

$money->divide('1.000005');
echo "$money\n"; // 321.55
echo $money->getWithFullPrecision() . "\n"; // 321.5492660931

# You can also compare really large numbers with one another, up to 10 decimal places.
# PHP Experts' MoneyType is cryptocurrency ready! In fact, that's what it was designed for!
$money->compare(321.5492660931);       // 0 = equal
$money->compare(321.549266093009);     // -1 = less
$money->compare(321.5492660931000001); // 1 = more

# Get the object.
print_r($money);
```

# Use cases

PHPExperts\MoneyType\Money  
 ✔ Will report what strategy is being used  
 ✔ Will use b c math if it is available  
 ✔ Will fall back to native php if necessary  
 ✔ Proxies everything to its calculation strategy  
 ✔ Confirm that the read me demo works

PHPExperts\MoneyType\BCMathCalcStrategy  
 ✔ Can get the full precision value to more than sixteen decimals  
 ✔ Can add with high precision  
 ✔ Can subtract with high precision  
 ✔ Can multiply with high precision  
 ✔ Can divide with high precision  
 ✔ Can compare two numbers with high precision  
 ✔ Can compute high precision modulus  
 ✔ Can compute the modulus of decimals  
 ✔ Can round with high precision  
 ✔ Can be instantiated with an integer  
 ✔ Can be instantiated with a float  
 ✔ Can be instantiated with a string  
 ✔ Access the object as a string to get its valuation  
 ✔ Can add with cent precision  
 ✔ Can subtract with cent precision  
 ✔ Can multiply with cent precision  
 ✔ Can divide with cent precision  
 ✔ Can compare two numbers with cent precision  

PHPExperts\MoneyType\NativeCalcStrategy  
 ✔ Wont attempt operations with non numbers  
 ✔ Can get the full precision value to two decimals  
 ✔ Cannot compute the modulus of decimals  
 ✔ Will throw an exception if asked to compute an integer modulus  
 ✔ Can compute the modulus of integers if dev passes i am a dummy parameter  
 ✔ Can be instantiated with an integer  
 ✔ Can be instantiated with a float  
 ✔ Can be instantiated with a string  
 ✔ Access the object as a string to get its valuation  
 ✔ Can add with cent precision  
 ✔ Can subtract with cent precision  
 ✔ Can multiply with cent precision  
 ✔ Can divide with cent precision  
 ✔ Can compare two numbers with cent precision

PHPExperts\MoneyType\Internal\NumberHelper  
 ✔ Will return true if given a float  
 ✔ Will return true if given a float string  
 ✔ Will return false if given an integer  
 ✔ Will return false if given an integer string  
 ✔ Will throw an exception if given anything else

## Testing

```bash
phpunit
```

# Contributors

[Theodore R. Smith](https://www.phpexperts.pro/]) <theodore@phpexperts.pro>  
GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690  
CEO: PHP Experts, Inc.

[[Alix Axel](https://stackoverflow.com/users/89771/alix-axel)]  
who contributed the base version of our "bcround()" function
from https://stackoverflow.com/a/1653826/430062.

## License

MIT license. Please see the [license file](LICENSE) for more information.

