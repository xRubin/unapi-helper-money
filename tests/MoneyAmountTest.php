<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use unapi\helper\money\Currency;
use unapi\helper\money\MoneyAmount;
use unapi\helper\money\WrongCurrencyException;

class MoneyAmountTest extends TestCase
{
    public function testCanCreateObject()
    {
        $money = new MoneyAmount(20.0, new Currency(Currency::EUR));
        $this->assertSame(20.0, $money->getAmount());
        $this->assertSame('EUR', $money->getCurrency()->value);
    }

    public function testCanAddAmountWithSameCurrency()
    {
        $money = new MoneyAmount(20.0, new Currency(Currency::EUR));
        $money2 = new MoneyAmount(5.0, new Currency(Currency::EUR));
        $result = $money->add($money2);
        $this->assertSame(25.0, $result->getAmount());
        $this->assertSame('EUR', $result->getCurrency()->value);
    }

    public function testCannotAddAmountWithDifferentCurrency()
    {
        $money = new MoneyAmount(20.0, new Currency(Currency::EUR));
        $money2 = new MoneyAmount(5.0, new Currency(Currency::USD));
        $this->expectException(WrongCurrencyException::class);
        $result = $money->add($money2);
    }

    public function testCanSubAmountWithSameCurrency()
    {
        $money = new MoneyAmount(20.0, new Currency(Currency::EUR));
        $money2 = new MoneyAmount(5.0, new Currency(Currency::EUR));
        $result = $money->sub($money2);
        $this->assertSame(15.0, $result->getAmount());
        $this->assertSame('EUR', $result->getCurrency()->value);
    }

    public function testCannotSubAmountWithDifferentCurrency()
    {
        $money = new MoneyAmount(20.0, new Currency(Currency::EUR));
        $money2 = new MoneyAmount(5.0, new Currency(Currency::USD));
        $this->expectException(WrongCurrencyException::class);
        $result = $money->sub($money2);
    }

    public function testCanMultiplyMoney()
    {
        $money = new MoneyAmount(20.0, new Currency(Currency::EUR));
        $result = $money->multiply(2);
        $this->assertSame(40.0, $result->getAmount());
        $this->assertSame('EUR', $result->getCurrency()->value);
    }

    public function testSmallAmountIsZero()
    {
        $money = new MoneyAmount(1e-6, new Currency(Currency::EUR));
        $this->assertTrue($money->isZero());
        $money = new MoneyAmount(-1e-6, new Currency(Currency::EUR));
        $this->assertTrue($money->isZero());
    }

    public function testIsNegative()
    {
        $money = new MoneyAmount(20.0, new Currency(Currency::EUR));
        $this->assertFalse($money->isNegative());
        $money = new MoneyAmount(-20, new Currency(Currency::EUR));
        $this->assertTrue($money->isNegative());
    }
}