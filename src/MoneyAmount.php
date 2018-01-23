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
}