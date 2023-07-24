<?php

namespace unapi\helper\money;

class MoneyAmount
{
    /** @var float */
    private $amount;
    /** @var Currency */
    private $currency;

    public function __construct($amount, Currency $currency)
    {
        $this->amount = (float)str_replace(',', '.', $amount);
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param MoneyAmount $money
     * @return MoneyAmount
     */
    public function add(self $money): MoneyAmount
    {
        if ($this->currency->value !== $money->currency->value)
            throw new WrongCurrencyException();

        return new MoneyAmount(
            $this->getAmount() + $money->getAmount(),
            $this->getCurrency()
        );
    }

    /**
     * @param MoneyAmount $money
     * @return MoneyAmount
     */
    public function sub(self $money): MoneyAmount
    {
        if ($this->currency->value !== $money->currency->value)
            throw new WrongCurrencyException();

        return new MoneyAmount(
            $this->getAmount() - $money->getAmount(),
            $this->getCurrency()
        );
    }

    /**
     * @param $k
     * @return MoneyAmount
     */
    public function multiply($k): MoneyAmount
    {
        return new MoneyAmount(
            $this->getAmount() * $k,
            $this->getCurrency()
        );
    }

    /**
     * @return bool
     */
    public function isZero(): bool
    {
        return abs($this->getAmount()) < 0.005;
    }
}