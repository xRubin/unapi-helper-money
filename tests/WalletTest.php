<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use unapi\helper\money\Currency;
use unapi\helper\money\MoneyAmount;
use unapi\helper\money\Wallet;

class WalletTest extends TestCase
{
    public function testCanCreateObject()
    {
        $wallet = new Wallet([
            new MoneyAmount(20.0, new Currency(Currency::EUR)),
        ]);
        $money = $wallet->getMoney();
        $this->assertIsArray($money);
        $this->assertCount(1, $money);
        $this->assertInstanceOf(MoneyAmount::class, $money[0]);
        $this->assertSame('EUR', $money[0]->getCurrency()->value);
    }

    public function testNoReturnOfZeroValues()
    {
        $wallet = new Wallet([
            new MoneyAmount(20.0, new Currency(Currency::EUR)),
            new MoneyAmount(0.0, new Currency(Currency::USD)),
        ]);
        $money = $wallet->getMoney();
        $this->assertIsArray($money);
        $this->assertCount(1, $money);
        $this->assertInstanceOf(MoneyAmount::class, $money[0]);
        $this->assertSame('EUR', $money[0]->getCurrency()->value);
    }

    public function testGetMoneyByCurrencyPositive()
    {
        $wallet = new Wallet([
            new MoneyAmount(10.0, new Currency(Currency::EUR)),
            new MoneyAmount(20.0, new Currency(Currency::USD)),
        ]);
        $result = $wallet->getMoneyByCurrency(new Currency(Currency::USD));
        $this->assertInstanceOf(MoneyAmount::class, $result);
        $this->assertSame('USD', $result->getCurrency()->value);
    }

    public function testGetMoneyByCurrencyNegative()
    {
        $wallet = new Wallet([
            new MoneyAmount(10.0, new Currency(Currency::EUR)),
            new MoneyAmount(20.0, new Currency(Currency::USD)),
        ]);
        $result = $wallet->getMoneyByCurrency(new Currency(Currency::RUB));
        $this->assertNull($result);
    }

    public function testCanAddAmountWithSameCurrency()
    {
        $wallet = new Wallet([
            new MoneyAmount(20.0, new Currency(Currency::EUR)),
        ]);
        $wallet->addMoney(
            new MoneyAmount(5.0, new Currency(Currency::EUR))
        );
        $result = $wallet->getMoneyByCurrency(new Currency(Currency::EUR));
        $this->assertSame(25.0, $result->getAmount());
        $this->assertSame('EUR', $result->getCurrency()->value);
    }

    public function testCanAddAmountWithDifferentCurrency()
    {
        $wallet = new Wallet([
            new MoneyAmount(20.0, new Currency(Currency::EUR)),
        ]);
        $wallet->addMoney(
            new MoneyAmount(5.0, new Currency(Currency::USD))
        );
        $this->assertIsArray($wallet->getMoney());
        $this->assertCount(2, $wallet->getMoney());
    }

    public function testCanSubAmountWithSameCurrency()
    {
        $wallet = new Wallet([
            new MoneyAmount(20.0, new Currency(Currency::EUR)),
        ]);
        $wallet->subMoney(
            new MoneyAmount(5.0, new Currency(Currency::EUR))
        );
        $result = $wallet->getMoneyByCurrency(new Currency(Currency::EUR));
        $this->assertSame(15.0, $result->getAmount());
        $this->assertSame('EUR', $result->getCurrency()->value);
    }

    public function testCanSubAmountWithDifferentCurrency()
    {
        $wallet = new Wallet([
            new MoneyAmount(20.0, new Currency(Currency::EUR)),
        ]);
        $wallet->subMoney(
            new MoneyAmount(5.0, new Currency(Currency::USD))
        );
        $this->assertIsArray($wallet->getMoney());
        $this->assertCount(2, $wallet->getMoney());
        $this->assertEquals(
            new MoneyAmount(-5.0, new Currency(Currency::USD)),
            $wallet->getMoneyByCurrency(new Currency(Currency::USD))
        );
    }

    public function testNegativeAmountCheck()
    {
        $wallet = new Wallet([
            new MoneyAmount(20.0, new Currency(Currency::EUR)),
            new MoneyAmount(-5.0, new Currency(Currency::USD)),
        ]);
        $this->assertTrue($wallet->hasNegativeAmount());
    }
}