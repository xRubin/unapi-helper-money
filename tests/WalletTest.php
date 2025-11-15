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
            new MoneyAmount(20, new Currency(Currency::EUR)),
        ]);
        $money = $wallet->getMoney();
        $this->assertIsArray($money);
        $this->assertCount(1, $money);
        $this->assertInstanceOf(MoneyAmount::class, $money[0]);
        $this->assertSame('EUR', $money[0]->getCurrency()->value);
    }

    public function testCanAddAmountWithSameCurrency()
    {
        $wallet = new Wallet([
            new MoneyAmount(20, new Currency(Currency::EUR)),
        ]);
        $wallet2 = $wallet->addMoney(
            new MoneyAmount(5, new Currency(Currency::EUR))
        );
        $result = $wallet2->getMoneyByCurrency(new Currency(Currency::EUR));
        $this->assertSame(25.0, $result->getAmount());
        $this->assertSame('EUR', $result->getCurrency()->value);
    }

    public function testCanAddAmountWithDifferentCurrency()
    {
        $wallet = new Wallet([
            new MoneyAmount(20, new Currency(Currency::EUR)),
        ]);
        $wallet2 = $wallet->addMoney(
            new MoneyAmount(5, new Currency(Currency::USD))
        );
        $this->assertCount(1, $wallet->getMoney());
        $this->assertIsArray($wallet2->getMoney());
        $this->assertCount(2, $wallet2->getMoney());
    }

    public function testNegativeAmountCheck()
    {
        $wallet = new Wallet([
            new MoneyAmount(20, new Currency(Currency::EUR)),
            new MoneyAmount(-5, new Currency(Currency::USD)),
        ]);
        $this->assertTrue($wallet->hasNegativeAmount());
    }
}