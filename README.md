# Unapi Money

[![Build Status](https://github.com/xRubin/OpenSky/workflows/CI/badge.svg)](https://github.com/xRubin/OpenSky/actions)
[![Latest Stable Version](http://poser.pugx.org/rubin/opensky/v)](https://packagist.org/packages/rubin/opensky)
[![Coverage Status](https://coveralls.io/repos/github/xRubin/OpenSky/badge.svg?branch=master)](https://coveralls.io/github/xRubin/OpenSky?branch=master)
[![PHP Version Require](http://poser.pugx.org/rubin/opensky/require/php)](https://packagist.org/packages/rubin/opensky)

PHP implementation for the MoneyAmount pattern.

## Installation

With composer:
```bash
composer require unapi/helper-money
```

## Usage

Create Money amount:
```php
use unapi\helper\money\MoneyAmount;
use unapi\helper\money\Currency;
$money = new MoneyAmount(20.0, new Currency(Currency::EUR));
```

Create wallet:
```php
use unapi\helper\money\Wallet;
use unapi\helper\money\MoneyAmount;
use unapi\helper\money\Currency;
$wallet = new Wallet([
    new MoneyAmount(20.0, new Currency(Currency::EUR))
    new MoneyAmount(10.0, new Currency(Currency::USD))
]);
$newWallet = $wallet->addMoney(
    new MoneyAmount(5.0, new Currency(Currency::EUR))
);
```